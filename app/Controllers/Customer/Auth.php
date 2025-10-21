<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Auth extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        // If already logged in, redirect to account
        if (session()->get('customer_logged_in')) {
            return redirect()->to('/account');
        }

        $data = [
            'title' => 'Customer Login',
        ];

        return view('customer/auth/login', $data);
    }

    public function loginPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $customer = $this->customerModel->verifyPassword($email, $password);

        if ($customer) {
            session()->set([
                'customer_id'         => $customer['id'],
                'customer_name'       => $customer['name'],
                'customer_email'      => $customer['email'],
                'customer_logged_in'  => true,
            ]);

            return redirect()->to('/account')->with('success', 'Welcome back, ' . $customer['name']);
        }

        return redirect()->back()->withInput()->with('error', 'Invalid email or password');
    }

    public function register()
    {
        $data = [
            'title' => 'Customer Registration',
        ];

        return view('customer/auth/register', $data);
    }

    public function registerPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[customers.email]',
            'password' => 'required|min_length[6]',
            'phone'    => 'permit_empty|max_length[20]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'phone'    => $this->request->getPost('phone'),
            'address'  => $this->request->getPost('address'),
        ];

        if ($this->customerModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
        }

        return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
    }

    public function logout()
    {
        session()->remove(['customer_id', 'customer_name', 'customer_email', 'customer_logged_in']);
        return redirect()->to('/')->with('success', 'You have been logged out');
    }
}
