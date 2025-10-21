<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\CustomerModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $orderModel = new OrderModel();
        $customerModel = new CustomerModel();

        $data = [
            'title'           => 'Admin Dashboard',
            'total_products'  => $productModel->countAll(),
            'total_categories'=> $categoryModel->countAll(),
            'total_orders'    => $orderModel->countAll(),
            'total_customers' => $customerModel->countAll(),
            'recent_orders'   => $orderModel->getOrdersWithCustomers(),
        ];

        return view('admin/dashboard', $data);
    }
}
