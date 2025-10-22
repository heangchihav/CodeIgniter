<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Products extends BaseController
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
            'title'    => 'Manage Products',
            'products' => $this->productModel->getWithCategory(),
        ];

        return view('admin/products/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Add New Product',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('admin/products/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'category_id' => 'required|integer',
            'name'        => 'required|min_length[3]|max_length[200]',
            'slug'        => 'required|is_unique[products.slug]',
            'price'       => 'required|decimal',
            'stock'       => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $originalPrice = $this->request->getPost('original_price');
        $discountPercentage = $this->request->getPost('discount_percentage');
        $autoCalculate = $this->request->getPost('auto_calculate_features');
        
        $data = [
            'category_id'         => $this->request->getPost('category_id'),
            'name'                => $this->request->getPost('name'),
            'slug'                => $this->request->getPost('slug'),
            'description'         => $this->request->getPost('description'),
            'price'               => $this->request->getPost('price'),
            'original_price'      => ($originalPrice && $originalPrice !== '') ? $originalPrice : null,
            'discount_percentage' => ($discountPercentage && $discountPercentage !== '') ? $discountPercentage : 0,
            'stock'               => $this->request->getPost('stock'),
            'image'               => $this->request->getPost('image'),
            'is_active'           => $this->request->getPost('is_active') ? true : false,
        ];

        // Only set manual values if auto-calculate is not enabled
        if (!$autoCalculate) {
            $data['is_featured'] = $this->request->getPost('is_featured') ? true : false;
            $data['is_new'] = $this->request->getPost('is_new') ? true : false;
            $data['is_popular'] = $this->request->getPost('is_popular') ? true : false;
        }

        $productId = $this->productModel->insert($data);

        if ($productId && $autoCalculate) {
            // Auto-calculate features after product is created
            $this->productModel->autoCalculateFeatures($productId);
        }

        if ($productId) {
            // Handle multiple images
            $images = $this->request->getPost('images');
            if ($images && is_array($images)) {
                foreach ($images as $index => $imageUrl) {
                    if (!empty($imageUrl)) {
                        $imageData = [
                            'product_id' => $productId,
                            'image_url'  => $imageUrl,
                            'is_primary' => ($index == 0), // First image is primary
                            'sort_order' => $index,
                        ];
                        $this->productImageModel->insert($imageData);
                    }
                }
            }
            
            return redirect()->to('/admin/products')->with('success', 'Product created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create product');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'         => 'Edit Product',
            'product'       => $product,
            'categories'    => $this->categoryModel->findAll(),
            'product_images'=> $this->productImageModel->getProductImages($id),
        ];

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'category_id' => 'required|integer',
            'name'        => 'required|min_length[3]|max_length[200]',
            'price'       => 'required|decimal',
            'stock'       => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $originalPrice = $this->request->getPost('original_price');
        $discountPercentage = $this->request->getPost('discount_percentage');
        $autoCalculate = $this->request->getPost('auto_calculate_features');
        
        $data = [
            'category_id'         => $this->request->getPost('category_id'),
            'name'                => $this->request->getPost('name'),
            'description'         => $this->request->getPost('description'),
            'price'               => $this->request->getPost('price'),
            'original_price'      => ($originalPrice && $originalPrice !== '') ? $originalPrice : null,
            'discount_percentage' => ($discountPercentage && $discountPercentage !== '') ? $discountPercentage : 0,
            'stock'               => $this->request->getPost('stock'),
            'image'               => $this->request->getPost('image'),
            'is_active'           => $this->request->getPost('is_active') ? true : false,
        ];

        // Only set manual values if auto-calculate is not enabled
        if (!$autoCalculate) {
            $data['is_featured'] = $this->request->getPost('is_featured') ? true : false;
            $data['is_new'] = $this->request->getPost('is_new') ? true : false;
            $data['is_popular'] = $this->request->getPost('is_popular') ? true : false;
        }

        if ($this->productModel->update($id, $data)) {
            // Auto-calculate features if enabled
            if ($autoCalculate) {
                $this->productModel->autoCalculateFeatures($id);
            }
            return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update product');
    }

    public function delete($id)
    {
        if ($this->productModel->delete($id)) {
            return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete product');
    }

    public function addImage($productId)
    {
        $imageUrl = $this->request->getPost('image_url');
        
        if (empty($imageUrl)) {
            return redirect()->to('/admin/products/edit/' . $productId)->with('error', 'Image URL is required');
        }

        // Verify product exists
        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Get current max sort order
        $images = $this->productImageModel->getProductImages($productId);
        $maxOrder = count($images);

        $imageData = [
            'product_id' => $productId,
            'image_url'  => $imageUrl,
            'is_primary' => (count($images) == 0), // First image is primary
            'sort_order' => $maxOrder,
        ];

        if ($this->productImageModel->insert($imageData)) {
            return redirect()->to('/admin/products/edit/' . $productId)->with('success', 'Image added successfully');
        }

        return redirect()->to('/admin/products/edit/' . $productId)->with('error', 'Failed to add image');
    }

    public function deleteImage($imageId)
    {
        // Verify this is an image ID, not a product ID
        $image = $this->productImageModel->find($imageId);
        
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        $productId = $image['product_id'];

        if ($this->productImageModel->delete($imageId)) {
            return redirect()->to('/admin/products/edit/' . $productId)->with('success', 'Image deleted successfully');
        }

        return redirect()->to('/admin/products/edit/' . $productId)->with('error', 'Failed to delete image');
    }

    public function setPrimaryImage($productId, $imageId)
    {
        // Verify product and image exist
        $product = $this->productModel->find($productId);
        $image = $this->productImageModel->find($imageId);
        
        if (!$product || !$image) {
            return redirect()->to('/admin/products')->with('error', 'Product or image not found');
        }

        if ($this->productImageModel->setPrimaryImage($productId, $imageId)) {
            return redirect()->to('/admin/products/edit/' . $productId)->with('success', 'Primary image updated successfully');
        }

        return redirect()->to('/admin/products/edit/' . $productId)->with('error', 'Failed to update primary image');
    }
}
