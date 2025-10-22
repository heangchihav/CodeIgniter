<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\BannerModel;

class Shop extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productImageModel;
    protected $bannerModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
        $this->bannerModel = new BannerModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'              => 'Shop - Home',
            'banners'            => $this->bannerModel->getActiveBanners(),
            'featuredProducts'   => $this->productModel->getFeaturedProducts(8),
            'newProducts'        => $this->productModel->getNewProducts(8),
            'popularProducts'    => $this->productModel->getPopularProducts(8),
            'discountedProducts' => $this->productModel->getDiscountedProducts(8),
            'allProducts'        => $this->productModel->where('is_active', true)->findAll(),
            'categories'         => $this->categoryModel->findAll(),
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
        
        if (empty($keyword)) {
            return redirect()->to('/products');
        }

        $products = $this->productModel->searchProducts($keyword);

        $data = [
            'title'      => 'Search Results: ' . $keyword,
            'products'   => $products,
            'categories' => $this->categoryModel->findAll(),
            'keyword'    => $keyword,
        ];

        return view('shop/products', $data);
    }

    public function featured()
    {
        $data = [
            'title'      => 'Featured Products',
            'products'   => $this->productModel->getFeaturedProducts(100),
            'categories' => $this->categoryModel->findAll(),
            'filter'     => 'featured',
        ];

        return view('shop/products', $data);
    }

    public function newArrivals()
    {
        $data = [
            'title'      => 'New Arrivals',
            'products'   => $this->productModel->getNewProducts(100),
            'categories' => $this->categoryModel->findAll(),
            'filter'     => 'new',
        ];

        return view('shop/products', $data);
    }

    public function popular()
    {
        $data = [
            'title'      => 'Popular Products',
            'products'   => $this->productModel->getPopularProducts(100),
            'categories' => $this->categoryModel->findAll(),
            'filter'     => 'popular',
        ];

        return view('shop/products', $data);
    }

    public function deals()
    {
        $data = [
            'title'      => 'Flash Deals',
            'products'   => $this->productModel->getDiscountedProducts(100),
            'categories' => $this->categoryModel->findAll(),
            'filter'     => 'deals',
        ];

        return view('shop/products', $data);
    }
}
