<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Checkout extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $subtotal = $product['price'] * $quantity;
                $cartItems[] = [
                    'product'  => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        $data = [
            'title'     => 'Checkout',
            'cartItems' => $cartItems,
            'total'     => $total,
        ];

        return view('shop/checkout', $data);
    }

    public function process()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty');
        }

        $validation = \Config\Services::validation();
        
        // Different validation rules for logged-in vs guest users
        if (session()->get('customer_logged_in')) {
            $validation->setRules([
                'shipping_address' => 'required|min_length[10]',
            ]);
        } else {
            $validation->setRules([
                'customer_name'    => 'required|min_length[3]',
                'customer_email'   => 'required|valid_email',
                'customer_phone'   => 'required',
                'shipping_address' => 'required|min_length[10]',
            ]);
        }

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $total += $product['price'] * $quantity;
            }
        }

        // Get customer ID if logged in, otherwise create/find guest customer
        $customerId = session()->get('customer_id');
        
        if (!$customerId) {
            // Create guest customer record
            $customerModel = new \App\Models\CustomerModel();
            $customerData = [
                'name'     => $this->request->getPost('customer_name'),
                'email'    => $this->request->getPost('customer_email'),
                'phone'    => $this->request->getPost('customer_phone'),
                'password' => password_hash(uniqid(), PASSWORD_DEFAULT), // Random password for guest
                'address'  => $this->request->getPost('shipping_address'),
            ];
            
            // Check if email exists
            $existingCustomer = $customerModel->where('email', $customerData['email'])->first();
            if ($existingCustomer) {
                $customerId = $existingCustomer['id'];
            } else {
                $customerId = $customerModel->insert($customerData);
            }
        }

        // Create order
        $orderData = [
            'customer_id'      => $customerId,
            'order_number'     => $this->orderModel->generateOrderNumber(),
            'total_amount'     => $total,
            'status'           => 'pending',
            'shipping_address' => $this->request->getPost('shipping_address'),
            'notes'            => $this->request->getPost('notes'),
        ];

        $orderId = $this->orderModel->insert($orderData);

        if ($orderId) {
            // Create order items
            foreach ($cart as $productId => $quantity) {
                $product = $this->productModel->find($productId);
                if ($product) {
                    $itemData = [
                        'order_id'   => $orderId,
                        'product_id' => $productId,
                        'quantity'   => $quantity,
                        'price'      => $product['price'],
                        'subtotal'   => $product['price'] * $quantity,
                    ];
                    $this->orderItemModel->insert($itemData);

                    // Update stock
                    $newStock = $product['stock'] - $quantity;
                    $this->productModel->update($productId, ['stock' => $newStock]);
                }
            }

            // Clear cart
            session()->remove('cart');

            return redirect()->to('/checkout/success/' . $orderId);
        }

        return redirect()->back()->with('error', 'Failed to process order');
    }

    public function success($orderId)
    {
        $order = $this->orderModel->getOrderWithItems($orderId);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Order Success',
            'order' => $order,
        ];

        return view('shop/order_success', $data);
    }
}
