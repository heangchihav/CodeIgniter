<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'E-Commerce') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden mr-2 text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <a href="<?= base_url('/') ?>" class="flex-shrink-0 flex items-center">
                        <span class="text-xl md:text-2xl font-bold text-indigo-600">E-Shop</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <?php 
                        $currentPath = uri_string();
                        $homeActive = ($currentPath === '' || $currentPath === '/') ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-900 hover:text-indigo-600';
                        $productsActive = (strpos($currentPath, 'products') !== false || strpos($currentPath, 'product/') !== false) ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-900 hover:text-indigo-600';
                        ?>
                        <a href="<?= base_url('/') ?>" class="<?= $homeActive ?> px-3 py-2 text-sm font-medium">Home</a>
                        <a href="<?= base_url('/products') ?>" class="<?= $productsActive ?> px-3 py-2 text-sm font-medium">Products</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 md:space-x-4">
                    <!-- Search Form -->
                    <form action="<?= base_url('/search') ?>" method="get" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Search products..." 
                                   class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Cart -->
                    <a href="<?= base_url('/cart') ?>" class="relative text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <?php 
                        $cart = session()->get('cart') ?? [];
                        $cartCount = array_sum($cart);
                        if ($cartCount > 0): 
                        ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?= $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </a>

                    <!-- User Account -->
                    <?php if (session()->get('customer_logged_in')): ?>
                        <div class="relative group">
                            <button class="flex items-center text-gray-700 hover:text-indigo-600 py-2">
                                <i class="fas fa-user-circle text-xl mr-1"></i>
                                <span class="hidden md:inline"><?= esc(session()->get('customer_name')) ?></span>
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>
                            <div class="absolute right-0 top-full pt-1 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                <div class="bg-white rounded-lg shadow-lg py-2">
                                    <a href="<?= base_url('/account') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                    </a>
                                    <a href="<?= base_url('/account/orders') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-shopping-bag mr-2"></i> My Orders
                                    </a>
                                    <a href="<?= base_url('/account/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <hr class="my-2">
                                    <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>     
                    <?php else: ?>
                        <a href="<?= base_url('/login') ?>" class="text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-user text-xl"></i>
                            <span class="hidden md:inline ml-1">Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <div class="space-y-1">
                    <a href="<?= base_url('/') ?>" class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                    <a href="<?= base_url('/products') ?>" class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-box mr-2"></i> Products
                    </a>
                    <a href="<?= base_url('/cart') ?>" class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-shopping-cart mr-2"></i> Cart
                        <?php if ($cartCount > 0): ?>
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                    
                </div>
            </div>
        </div>
    </nav>

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
    </script>

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
