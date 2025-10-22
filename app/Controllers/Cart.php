<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $cart = session()->get('cart') ?? [];
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
            'title'     => 'Shopping Cart',
            'cartItems' => $cartItems,
            'total'     => $total,
        ];

        return view('shop/cart', $data);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $product = $this->productModel->find($productId);

        if (!$product) {
            // Check if request is AJAX
            if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => 'Product not found'
                    ]);
            }
            return redirect()->back()->with('error', 'Product not found');
        }

        $cart = session()->get('cart') ?? [];
        
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->set('cart', $cart);

        // Calculate total cart count
        $cartCount = array_sum($cart);

        // Check if request is AJAX
        if ($this->request->isAJAX() || $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $this->response
                ->setContentType('application/json')
                ->setJSON([
                    'success' => true,
                    'message' => 'Product added to cart successfully!',
                    'cartCount' => $cartCount
                ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function update()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId] = $quantity;
            } else {
                unset($cart[$productId]);
            }
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Cart updated');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/cart')->with('success', 'Cart cleared');
    }
}
