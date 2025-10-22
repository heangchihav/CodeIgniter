<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'name', 'slug', 'description', 
        'price', 'original_price', 'stock', 'image', 'is_active', 
        'is_featured', 'is_new', 'is_popular', 'discount_percentage'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'category_id' => 'required|integer',
        'name'        => 'required|min_length[3]|max_length[200]',
        'slug'        => 'required|is_unique[products.slug]|max_length[200]',
        'price'       => 'required|decimal',
        'stock'       => 'required|integer',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getWithCategory($id = null)
    {
        $builder = $this->select('products.*, categories.name as category_name')
                        ->join('categories', 'categories.id = products.category_id');
        
        if ($id !== null) {
            return $builder->where('products.id', $id)->first();
        }
        
        return $builder->where('products.is_active', true)->findAll();
    }

    public function getByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->where('is_active', true)
                    ->findAll();
    }

    public function searchProducts($keyword)
    {
        return $this->like('name', $keyword)
                    ->orLike('description', $keyword)
                    ->where('is_active', true)
                    ->findAll();
    }

    public function getFeaturedProducts($limit = 8)
    {
        return $this->where('is_featured', true)
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getNewProducts($limit = 8)
    {
        return $this->where('is_new', true)
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getPopularProducts($limit = 8)
    {
        return $this->where('is_popular', true)
                    ->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getDiscountedProducts($limit = 8)
    {
        return $this->where('discount_percentage >', 0)
                    ->where('is_active', true)
                    ->orderBy('discount_percentage', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Auto-calculate product features based on real metrics
     */
    public function autoCalculateFeatures($productId)
    {
        $product = $this->find($productId);
        if (!$product) {
            return false;
        }

        $updates = [];

        // Auto-detect NEW: Created within last 30 days
        $createdAt = strtotime($product['created_at']);
        $thirtyDaysAgo = strtotime('-30 days');
        $updates['is_new'] = ($createdAt >= $thirtyDaysAgo);

        // Auto-detect FEATURED: Has discount > 15% OR high stock (>50)
        $hasGoodDiscount = ($product['discount_percentage'] ?? 0) > 15;
        $hasHighStock = ($product['stock'] ?? 0) > 50;
        $updates['is_featured'] = ($hasGoodDiscount || $hasHighStock);

        // Auto-detect POPULAR: Will be based on order count (for now, use stock sold logic)
        // If stock is between 20-50, assume it's selling well
        $stock = $product['stock'] ?? 0;
        $updates['is_popular'] = ($stock >= 20 && $stock <= 80);

        return $this->update($productId, $updates);
    }

    /**
     * Auto-calculate all products features
     */
    public function autoCalculateAllFeatures()
    {
        $products = $this->findAll();
        $updated = 0;

        foreach ($products as $product) {
            if ($this->autoCalculateFeatures($product['id'])) {
                $updated++;
            }
        }

        return $updated;
    }
}
