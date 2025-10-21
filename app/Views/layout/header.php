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
                    <a href="<?= base_url('/') ?>" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">E-Shop</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="<?= base_url('/') ?>" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="<?= base_url('/products') ?>" class="text-gray-900 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Products</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
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
                </div>
            </div>
        </div>
    </nav>

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
