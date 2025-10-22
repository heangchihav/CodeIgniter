<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table            = 'payment_methods';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'method_name',
        'bank_name',
        'account_name',
        'account_number',
        'qr_code_url',
        'instructions',
        'is_active',
        'display_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'method_name' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'method_name' => [
            'required' => 'Payment method name is required',
            'min_length' => 'Payment method name must be at least 3 characters',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get all active payment methods ordered by display_order
     */
    public function getActivePaymentMethods()
    {
        return $this->where('is_active', 1)
                    ->orderBy('display_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /**
     * Get payment method by ID
     */
    public function getPaymentMethod($id)
    {
        return $this->find($id);
    }
}
