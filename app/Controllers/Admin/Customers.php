<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\OrderModel;

class Customers extends BaseController
{
    protected $customerModel;
    protected $orderModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->orderModel = new OrderModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'     => 'Manage Customers',
            'customers' => $this->customerModel->findAll(),
        ];

        return view('admin/customers/index', $data);
    }

    public function view($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $orders = $this->orderModel->where('customer_id', $id)
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();

        $data = [
            'title'    => 'Customer Details',
            'customer' => $customer,
            'orders'   => $orders,
        ];

        return view('admin/customers/view', $data);
    }

    public function delete($id)
    {
        if ($this->customerModel->delete($id)) {
            return redirect()->to('/admin/customers')->with('success', 'Customer deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete customer');
    }
}
