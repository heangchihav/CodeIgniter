<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;

class Auth extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        $data = [
            'title' => 'Admin Login',
        ];

        return view('admin/auth/login', $data);
    }

    public function loginPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->adminUserModel->verifyLogin($username, $password);

        if ($user) {
            session()->set([
                'admin_id'         => $user['id'],
                'admin_username'   => $user['username'],
                'admin_email'      => $user['email'],
                'admin_full_name'  => $user['full_name'],
                'admin_logged_in'  => true,
            ]);

            return redirect()->to('/admin/dashboard')->with('success', 'Welcome back, ' . $user['full_name']);
        }

        return redirect()->back()->withInput()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'You have been logged out');
    }

    public function register()
    {
        $data = [
            'title' => 'Admin Registration',
        ];

        return view('admin/auth/register', $data);
    }

    public function registerPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username'  => 'required|min_length[3]|is_unique[admin_users.username]',
            'email'     => 'required|valid_email|is_unique[admin_users.email]',
            'password'  => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'is_active' => true,
        ];

        if ($this->adminUserModel->insert($data)) {
            return redirect()->to('/admin/login')->with('success', 'Registration successful! Please login.');
        }

        return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
    }
}
