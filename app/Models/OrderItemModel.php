<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id', 'product_id', 'quantity', 'price', 'subtotal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'order_id'   => 'required|integer',
        'product_id' => 'required|integer',
        'quantity'   => 'required|integer',
        'price'      => 'required|decimal',
        'subtotal'   => 'required|decimal',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getOrderItems($orderId)
    {
        return $this->select('order_items.*, products.name as product_name, products.image')
                    ->join('products', 'products.id = order_items.product_id')
                    ->where('order_items.order_id', $orderId)
                    ->findAll();
    }
}
