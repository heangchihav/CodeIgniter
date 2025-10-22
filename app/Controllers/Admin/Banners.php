<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class Banners extends BaseController
{
    protected $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Banners',
            'banners' => $this->bannerModel->orderBy('display_order', 'ASC')->findAll()
        ];

        return view('admin/banners/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Banner'
        ];

        return view('admin/banners/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
            'display_order' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/banners', $imageName);

        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'image' => $imageName,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'display_order' => $this->request->getPost('display_order'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->bannerModel->insert($data)) {
            return redirect()->to('/admin/banners')->with('success', 'Banner created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create banner');
    }

    public function edit($id)
    {
        $banner = $this->bannerModel->find($id);

        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner not found');
        }

        $data = [
            'title' => 'Edit Banner',
            'banner' => $banner
        ];

        return view('admin/banners/edit', $data);
    }

    public function update($id)
    {
        $banner = $this->bannerModel->find($id);

        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner not found');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'display_order' => 'required|numeric',
        ];

        // Only validate image if a new one is uploaded
        if ($this->request->getFile('image')->isValid()) {
            $rules['image'] = 'max_size[image,2048]|is_image[image]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'display_order' => $this->request->getPost('display_order'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle image upload if new image provided
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            // Delete old image
            if (file_exists(ROOTPATH . 'public/uploads/banners/' . $banner['image'])) {
                unlink(ROOTPATH . 'public/uploads/banners/' . $banner['image']);
            }

            $imageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/banners', $imageName);
            $data['image'] = $imageName;
        }

        if ($this->bannerModel->update($id, $data)) {
            return redirect()->to('/admin/banners')->with('success', 'Banner updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update banner');
    }

    public function delete($id)
    {
        $banner = $this->bannerModel->find($id);

        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner not found');
        }

        // Delete image file
        if (file_exists(ROOTPATH . 'public/uploads/banners/' . $banner['image'])) {
            unlink(ROOTPATH . 'public/uploads/banners/' . $banner['image']);
        }

        if ($this->bannerModel->delete($id)) {
            return redirect()->to('/admin/banners')->with('success', 'Banner deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete banner');
    }

    public function toggleStatus($id)
    {
        $banner = $this->bannerModel->find($id);

        if (!$banner) {
            return redirect()->to('/admin/banners')->with('error', 'Banner not found');
        }

        $newStatus = $banner['is_active'] ? 0 : 1;

        if ($this->bannerModel->update($id, ['is_active' => $newStatus])) {
            return redirect()->to('/admin/banners')->with('success', 'Banner status updated');
        }

        return redirect()->back()->with('error', 'Failed to update status');
    }
}
