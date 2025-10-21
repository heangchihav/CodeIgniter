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
                    <!-- Mobile menu button -->
                    <button onclick="toggleAdminMenu()" class="md:hidden mr-2 text-white hover:text-indigo-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <a href="<?= base_url('/admin/dashboard') ?>" class="flex-shrink-0 flex items-center">
                        <span class="text-xl md:text-2xl font-bold">Admin Panel</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-4">
                        <?php 
                        $currentPath = uri_string();
                        $dashboardActive = (strpos($currentPath, 'admin/dashboard') !== false) ? 'bg-indigo-800' : '';
                        $productsActive = (strpos($currentPath, 'admin/products') !== false) ? 'bg-indigo-800' : '';
                        $categoriesActive = (strpos($currentPath, 'admin/categories') !== false) ? 'bg-indigo-800' : '';
                        $ordersActive = (strpos($currentPath, 'admin/orders') !== false) ? 'bg-indigo-800' : '';
                        $customersActive = (strpos($currentPath, 'admin/customers') !== false) ? 'bg-indigo-800' : '';
                        ?>
                        <a href="<?= base_url('/admin/dashboard') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600 <?= $dashboardActive ?>">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="<?= base_url('/admin/products') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600 <?= $productsActive ?>">
                            <i class="fas fa-box mr-1"></i> Products
                        </a>
                        <a href="<?= base_url('/admin/categories') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600 <?= $categoriesActive ?>">
                            <i class="fas fa-tags mr-1"></i> Categories
                        </a>
                        <a href="<?= base_url('/admin/orders') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600 <?= $ordersActive ?>">
                            <i class="fas fa-shopping-cart mr-1"></i> Orders
                        </a>
                        <a href="<?= base_url('/admin/customers') ?>" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600 <?= $customersActive ?>">
                            <i class="fas fa-users mr-1"></i> Customers
                        </a>
                        <a href="<?= base_url('/') ?>" target="_blank" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-600">
                            <i class="fas fa-store mr-1"></i> View Shop
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 md:space-x-4">
                    <span class="text-xs md:text-sm hidden sm:inline">Welcome, <?= esc(session()->get('admin_full_name')) ?></span>
                    <a href="<?= base_url('/admin/logout') ?>" class="bg-red-600 hover:bg-red-700 px-3 md:px-4 py-2 rounded-md text-xs md:text-sm font-medium">
                        <i class="fas fa-sign-out-alt md:mr-1"></i> <span class="hidden md:inline">Logout</span>
                    </a>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="adminMobileMenu" class="hidden md:hidden pb-4">
                <div class="space-y-1">
                    <a href="<?= base_url('/admin/dashboard') ?>" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="<?= base_url('/admin/products') ?>" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-box mr-2"></i> Products
                    </a>
                    <a href="<?= base_url('/admin/categories') ?>" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-tags mr-2"></i> Categories
                    </a>
                    <a href="<?= base_url('/admin/orders') ?>" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-shopping-cart mr-2"></i> Orders
                    </a>
                    <a href="<?= base_url('/admin/customers') ?>" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-users mr-2"></i> Customers
                    </a>
                    <a href="<?= base_url('/') ?>" target="_blank" class="block px-3 py-2 text-base font-medium hover:bg-indigo-600 rounded-md">
                        <i class="fas fa-store mr-2"></i> View Shop
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
    function toggleAdminMenu() {
        const menu = document.getElementById('adminMobileMenu');
        menu.classList.toggle('hidden');
    }
    </script>
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
