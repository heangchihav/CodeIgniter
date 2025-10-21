<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php if (session()->get('admin_logged_in')): ?>
    <!-- Admin Navigation -->
    <nav class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= base_url('/admin/dashboard') ?>" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold">Admin Panel</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-4">
                        <a href="<?= base_url('/admin/dashboard') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="<?= base_url('/admin/products') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-box mr-1"></i> Products
                        </a>
                        <a href="<?= base_url('/admin/categories') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-tags mr-1"></i> Categories
                        </a>
                        <a href="<?= base_url('/admin/orders') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-shopping-cart mr-1"></i> Orders
                        </a>
                        <a href="<?= base_url('/admin/customers') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-users mr-1"></i> Customers
                        </a>
                        <a href="<?= base_url('/') ?>" target="_blank" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-store mr-1"></i> View Shop
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Welcome, <?= esc(session()->get('admin_full_name')) ?></span>
                    <a href="<?= base_url('/admin/logout') ?>" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="min-h-screen">
