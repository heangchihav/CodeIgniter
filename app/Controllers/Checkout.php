<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentMethodModel;

class Checkout extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentMethodModel = new PaymentMethodModel();
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

        // Get active payment methods
        $paymentMethods = $this->paymentMethodModel->getActivePaymentMethods();

        $data = [
            'title'          => 'Checkout',
            'cartItems'      => $cartItems,
            'total'          => $total,
            'paymentMethods' => $paymentMethods,
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

        // Handle payment slip upload
        $paymentSlipPath = null;
        $file = $this->request->getFile('payment_slip');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file
            $validationRules = [
                'payment_slip' => [
                    'uploaded[payment_slip]',
                    'max_size[payment_slip,5120]', // 5MB
                    'ext_in[payment_slip,jpg,jpeg,png,pdf]',
                ],
            ];
            
            if ($this->validate($validationRules)) {
                // Create uploads directory if it doesn't exist
                $uploadPath = WRITEPATH . '../public/uploads/payment_slips';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Generate unique filename
                $newName = 'slip_' . time() . '_' . uniqid() . '.' . $file->getExtension();
                
                // Move file
                if ($file->move($uploadPath, $newName)) {
                    $paymentSlipPath = 'uploads/payment_slips/' . $newName;
                }
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
            'payment_slip'     => $paymentSlipPath,
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
