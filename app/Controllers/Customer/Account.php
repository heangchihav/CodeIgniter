<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\CustomerModel;

class Account extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $customerModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->customerModel = new CustomerModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $customerId = session()->get('customer_id');
        
        $data = [
            'title'    => 'My Account',
            'customer' => $this->customerModel->find($customerId),
            'orders'   => $this->orderModel->where('customer_id', $customerId)
                                           ->orderBy('created_at', 'DESC')
                                           ->findAll(),
        ];

        return view('customer/account/dashboard', $data);
    }

    public function orders()
    {
        $customerId = session()->get('customer_id');
        
        $data = [
            'title'  => 'My Orders',
            'orders' => $this->orderModel->where('customer_id', $customerId)
                                         ->orderBy('created_at', 'DESC')
                                         ->findAll(),
        ];

        return view('customer/account/orders', $data);
    }

    public function orderDetail($orderId)
    {
        $customerId = session()->get('customer_id');
        
        $order = $this->orderModel->where('id', $orderId)
                                  ->where('customer_id', $customerId)
                                  ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $orderItems = $this->orderItemModel->getOrderItems($orderId);

        $data = [
            'title'       => 'Order Details',
            'order'       => $order,
            'order_items' => $orderItems,
        ];

        return view('customer/account/order_detail', $data);
    }

    public function profile()
    {
        $customerId = session()->get('customer_id');
        
        $data = [
            'title'    => 'My Profile',
            'customer' => $this->customerModel->find($customerId),
        ];

        return view('customer/account/profile', $data);
    }

    public function updateProfile()
    {
        $customerId = session()->get('customer_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'  => 'required|min_length[3]|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name'    => $this->request->getPost('name'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        if ($this->customerModel->update($customerId, $data)) {
            session()->set('customer_name', $data['name']);
            return redirect()->to('/account/profile')->with('success', 'Profile updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update profile');
    }

    public function uploadPaymentSlip($orderId)
    {
        $customerId = session()->get('customer_id');
        
        // Verify order belongs to customer
        $order = $this->orderModel->where('id', $orderId)
                                  ->where('customer_id', $customerId)
                                  ->first();
        
        if (!$order) {
            return redirect()->to('/account/orders')->with('error', 'Order not found');
        }
        
        // Handle file upload
        $file = $this->request->getFile('payment_slip');
        
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid file');
        }
        
        // Validate file
        $validationRules = [
            'payment_slip' => [
                'uploaded[payment_slip]',
                'max_size[payment_slip,5120]', // 5MB
                'ext_in[payment_slip,jpg,jpeg,png,pdf]',
            ],
        ];
        
        if (!$this->validate($validationRules)) {
            return redirect()->back()->with('error', 'Invalid file. Please upload JPG, PNG, or PDF (max 5MB)');
        }
        
        // Create uploads directory if it doesn't exist
        $uploadPath = WRITEPATH . '../public/uploads/payment_slips';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Delete old payment slip if exists
        if (!empty($order['payment_slip'])) {
            $oldFile = FCPATH . $order['payment_slip'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        
        // Generate unique filename
        $newName = 'slip_' . time() . '_' . uniqid() . '.' . $file->getExtension();
        
        // Move file
        if ($file->move($uploadPath, $newName)) {
            $paymentSlipPath = 'uploads/payment_slips/' . $newName;
            
            // Update order
            $this->orderModel->update($orderId, ['payment_slip' => $paymentSlipPath]);
            
            return redirect()->back()->with('success', 'Payment slip uploaded successfully');
        }
        
        return redirect()->back()->with('error', 'Failed to upload payment slip');
    }

    public function cancelOrder($orderId)
    {
        $customerId = session()->get('customer_id');
        
        // Verify order belongs to customer
        $order = $this->orderModel->where('id', $orderId)
                                  ->where('customer_id', $customerId)
                                  ->first();

        if (!$order) {
            return redirect()->to('/account/orders')->with('error', 'Order not found');
        }

        // Only allow cancellation if order is pending
        if ($order['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled');
        }

        // Update order status to cancelled
        if ($this->orderModel->update($orderId, ['status' => 'cancelled'])) {
            return redirect()->back()->with('success', 'Order cancelled successfully');
        }

        return redirect()->back()->with('error', 'Failed to cancel order');
    }
}
