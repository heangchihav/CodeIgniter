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
        'price', 'stock', 'image', 'is_active'
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
        return $this->where('is_active', true)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
