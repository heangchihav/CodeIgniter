<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'      => 'Manage Categories',
            'categories' => $this->categoryModel->getWithProducts(),
        ];

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Category',
        ];

        return view('admin/categories/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|is_unique[categories.slug]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create category');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Category',
            'category' => $category,
        ];

        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update category');
    }

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete category');
    }
}
