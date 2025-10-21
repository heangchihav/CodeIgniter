<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Shop extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Shop - Home',
            'products'   => $this->productModel->getFeaturedProducts(),
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('shop/index', $data);
    }

    public function products()
    {
        $categoryId = $this->request->getGet('category');
        
        if ($categoryId) {
            $products = $this->productModel->getByCategory($categoryId);
        } else {
            $products = $this->productModel->where('is_active', true)->findAll();
        }

        $data = [
            'title'      => 'All Products',
            'products'   => $products,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('shop/products', $data);
    }

    public function product($slug)
    {
        $product = $this->productModel->where('slug', $slug)->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $category = $this->categoryModel->find($product['category_id']);
        $relatedProducts = $this->productModel->getByCategory($product['category_id']);
        $productImages = $this->productImageModel->getProductImages($product['id']);

        $data = [
            'title'           => $product['name'],
            'product'         => $product,
            'category'        => $category,
            'relatedProducts' => array_slice($relatedProducts, 0, 4),
            'product_images'  => $productImages,
        ];

        return view('shop/product_detail', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        
        if ($keyword) {
            $products = $this->productModel->searchProducts($keyword);
        } else {
            $products = [];
        }

        $data = [
            'title'      => 'Search Results',
            'products'   => $products,
            'keyword'    => $keyword,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('shop/products', $data);
    }
}
