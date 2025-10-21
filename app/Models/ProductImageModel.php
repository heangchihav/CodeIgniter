<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table            = 'product_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'image_url', 'is_primary', 'sort_order'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'product_id' => 'required|integer',
        'image_url'  => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getProductImages($productId)
    {
        return $this->where('product_id', $productId)
                    ->orderBy('is_primary', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getPrimaryImage($productId)
    {
        return $this->where('product_id', $productId)
                    ->where('is_primary', true)
                    ->first();
    }

    public function setPrimaryImage($productId, $imageId)
    {
        // Remove primary flag from all images of this product
        $this->where('product_id', $productId)
             ->set(['is_primary' => false])
             ->update();

        // Set the new primary image
        return $this->update($imageId, ['is_primary' => true]);
    }
}
