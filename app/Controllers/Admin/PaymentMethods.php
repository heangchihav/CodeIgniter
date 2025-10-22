<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentMethodModel;

class PaymentMethods extends BaseController
{
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->paymentMethodModel = new PaymentMethodModel();
    }

    public function index()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Payment Methods',
            'paymentMethods' => $this->paymentMethodModel->orderBy('display_order', 'ASC')->findAll()
        ];

        return view('admin/payment_methods/index', $data);
    }

    public function create()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Add Payment Method'
        ];

        return view('admin/payment_methods/create', $data);
    }

    public function store()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $rules = [
            'method_name' => 'required|min_length[3]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'method_name' => $this->request->getPost('method_name'),
            'bank_name' => $this->request->getPost('bank_name'),
            'account_name' => $this->request->getPost('account_name'),
            'account_number' => $this->request->getPost('account_number'),
            'qr_code_url' => $this->request->getPost('qr_code_url'),
            'instructions' => $this->request->getPost('instructions'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order') ?? 0,
        ];

        if ($this->paymentMethodModel->insert($data)) {
            return redirect()->to('/admin/payment-methods')->with('success', 'Payment method added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add payment method');
        }
    }

    public function edit($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $paymentMethod = $this->paymentMethodModel->find($id);

        if (!$paymentMethod) {
            return redirect()->to('/admin/payment-methods')->with('error', 'Payment method not found');
        }

        $data = [
            'title' => 'Edit Payment Method',
            'paymentMethod' => $paymentMethod
        ];

        return view('admin/payment_methods/edit', $data);
    }

    public function update($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $paymentMethod = $this->paymentMethodModel->find($id);

        if (!$paymentMethod) {
            return redirect()->to('/admin/payment-methods')->with('error', 'Payment method not found');
        }

        $rules = [
            'method_name' => 'required|min_length[3]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'method_name' => $this->request->getPost('method_name'),
            'bank_name' => $this->request->getPost('bank_name'),
            'account_name' => $this->request->getPost('account_name'),
            'account_number' => $this->request->getPost('account_number'),
            'qr_code_url' => $this->request->getPost('qr_code_url'),
            'instructions' => $this->request->getPost('instructions'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order') ?? 0,
        ];

        if ($this->paymentMethodModel->update($id, $data)) {
            return redirect()->to('/admin/payment-methods')->with('success', 'Payment method updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update payment method');
        }
    }

    public function delete($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $paymentMethod = $this->paymentMethodModel->find($id);

        if (!$paymentMethod) {
            return redirect()->to('/admin/payment-methods')->with('error', 'Payment method not found');
        }

        if ($this->paymentMethodModel->delete($id)) {
            return redirect()->to('/admin/payment-methods')->with('success', 'Payment method deleted successfully');
        } else {
            return redirect()->to('/admin/payment-methods')->with('error', 'Failed to delete payment method');
        }
    }

    public function toggleStatus($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $paymentMethod = $this->paymentMethodModel->find($id);

        if (!$paymentMethod) {
            return redirect()->to('/admin/payment-methods')->with('error', 'Payment method not found');
        }

        $newStatus = $paymentMethod['is_active'] ? 0 : 1;

        if ($this->paymentMethodModel->update($id, ['is_active' => $newStatus])) {
            $message = $newStatus ? 'Payment method activated' : 'Payment method deactivated';
            return redirect()->to('/admin/payment-methods')->with('success', $message);
        } else {
            return redirect()->to('/admin/payment-methods')->with('error', 'Failed to update status');
        }
    }
}
