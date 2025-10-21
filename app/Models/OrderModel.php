<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_id', 'order_number', 'total_amount', 
        'status', 'shipping_address', 'notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'customer_id'       => 'required|integer',
        'order_number'      => 'required|is_unique[orders.order_number]',
        'total_amount'      => 'required|decimal',
        'shipping_address'  => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getCustomerOrders($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        
        if ($order) {
            $orderItemModel = new OrderItemModel();
            $order['items'] = $orderItemModel->getOrderItems($orderId);
        }
        
        return $order;
    }

    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
