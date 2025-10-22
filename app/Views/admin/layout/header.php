<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nav-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if (session()->get('admin_logged_in')): ?>
    <!-- Admin Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button onclick="toggleAdminMenu()" class="md:hidden mr-3 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Logo/Brand -->
                    <a href="<?= base_url('/admin/dashboard') ?>" class="flex items-center gap-3 px-2">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-shield-halved text-white text-lg"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-lg font-semibold text-gray-900">Admin Panel</span>
                            <div class="text-xs text-gray-500 -mt-0.5">Management System</div>
                        </div>
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:ml-8 md:flex md:items-center md:space-x-1">
                        <?php 
                        $currentPath = uri_string();
                        $dashboardActive = (strpos($currentPath, 'admin/dashboard') !== false) ? 'active' : '';
                        $productsActive = (strpos($currentPath, 'admin/products') !== false) ? 'active' : '';
                        $categoriesActive = (strpos($currentPath, 'admin/categories') !== false) ? 'active' : '';
                        $bannersActive = (strpos($currentPath, 'admin/banners') !== false) ? 'active' : '';
                        $ordersActive = (strpos($currentPath, 'admin/orders') !== false) ? 'active' : '';
                        $customersActive = (strpos($currentPath, 'admin/customers') !== false) ? 'active' : '';
                        $paymentMethodsActive = (strpos($currentPath, 'admin/payment-methods') !== false) ? 'active' : '';
                        ?>
                        <a href="<?= base_url('/admin/dashboard') ?>" class="nav-link <?= $dashboardActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-chart-line mr-1.5 text-gray-500"></i> Dashboard
                        </a>
                        <a href="<?= base_url('/admin/products') ?>" class="nav-link <?= $productsActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-box mr-1.5 text-gray-500"></i> Products
                        </a>
                        <a href="<?= base_url('/admin/categories') ?>" class="nav-link <?= $categoriesActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-tags mr-1.5 text-gray-500"></i> Categories
                        </a>
                        <a href="<?= base_url('/admin/banners') ?>" class="nav-link <?= $bannersActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-image mr-1.5 text-gray-500"></i> Banners
                        </a>
                        <a href="<?= base_url('/admin/orders') ?>" class="nav-link <?= $ordersActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-shopping-cart mr-1.5 text-gray-500"></i> Orders
                        </a>
                        <a href="<?= base_url('/admin/customers') ?>" class="nav-link <?= $customersActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-users mr-1.5 text-gray-500"></i> Customers
                        </a>
                        <a href="<?= base_url('/admin/payment-methods') ?>" class="nav-link <?= $paymentMethodsActive ?> px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                            <i class="fas fa-credit-card mr-1.5 text-gray-500"></i> Payments
                        </a>
                    </div>
                </div>
                
                <!-- Right Side Actions -->
                <div class="flex items-center gap-3">
                    <!-- View Shop -->
                    <a href="<?= base_url('/') ?>" target="_blank" class="hidden lg:flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt text-xs text-gray-500"></i>
                        <span>View Shop</span>
                    </a>
                    
                    <!-- Divider -->
                    <div class="hidden lg:block w-px h-6 bg-gray-300"></div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-medium text-gray-900"><?= esc(session()->get('admin_full_name')) ?></span>
                            <span class="text-xs text-gray-500">Administrator</span>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-700 rounded-lg flex items-center justify-center text-white font-semibold shadow-sm">
                            <?= strtoupper(substr(session()->get('admin_full_name'), 0, 1)) ?>
                        </div>
                    </div>
                    
                    <!-- Logout Button -->
                    <a href="<?= base_url('/admin/logout') ?>" class="flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden md:inline">Logout</span>
                    </a>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="adminMobileMenu" class="hidden md:hidden pb-3 border-t border-gray-200 mt-2">
                <div class="space-y-1 pt-2">
                    <a href="<?= base_url('/admin/dashboard') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-chart-line w-5 text-gray-500"></i> Dashboard
                    </a>
                    <a href="<?= base_url('/admin/products') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-box w-5 text-gray-500"></i> Products
                    </a>
                    <a href="<?= base_url('/admin/categories') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-tags w-5 text-gray-500"></i> Categories
                    </a>
                    <a href="<?= base_url('/admin/banners') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-image w-5 text-gray-500"></i> Banners
                    </a>
                    <a href="<?= base_url('/admin/orders') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-shopping-cart w-5 text-gray-500"></i> Orders
                    </a>
                    <a href="<?= base_url('/admin/customers') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-users w-5 text-gray-500"></i> Customers
                    </a>
                    <a href="<?= base_url('/admin/payment-methods') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-credit-card w-5 text-gray-500"></i> Payment Methods
                    </a>
                    <div class="border-t border-gray-200 my-2 pt-2">
                        <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-external-link-alt w-5 text-gray-500"></i> View Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
    function toggleAdminMenu() {
        const menu = document.getElementById('adminMobileMenu');
        menu.classList.toggle('hidden');
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('adminMobileMenu');
        const button = event.target.closest('button[onclick="toggleAdminMenu()"]');
        
        if (!menu.contains(event.target) && !button && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
        }
    });
    </script>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r shadow-sm flex items-start gap-3" role="alert">
            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-medium">Success</p>
                <p class="text-sm"><?= session()->getFlashdata('success') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r shadow-sm flex items-start gap-3" role="alert">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-medium">Error</p>
                <p class="text-sm"><?= session()->getFlashdata('error') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="min-h-screen">