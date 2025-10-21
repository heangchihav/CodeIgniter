<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\CustomerModel;

class Orders extends BaseController
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
        $data = [
            'title'  => 'Manage Orders',
            'orders' => $this->orderModel->getOrdersWithCustomers(),
        ];

        return view('admin/orders/index', $data);
    }

    public function view($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $customer = $this->customerModel->find($order['customer_id']);
        $orderItems = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title'       => 'Order Details',
            'order'       => $order,
            'customer'    => $customer,
            'order_items' => $orderItems,
        ];

        return view('admin/orders/view', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }

        if ($this->orderModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Order status updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update order status');
    }

    public function delete($id)
    {
        if ($this->orderModel->delete($id)) {
            return redirect()->to('/admin/orders')->with('success', 'Order deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete order');
    }
}
