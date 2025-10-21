<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-600 to-purple-700 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Admin Login</h1>
                <p class="text-gray-600 mt-2">Sign in to access admin panel</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('/admin/login') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-user mr-1"></i> Username or Email
                    </label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Enter username or email">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-lock mr-1"></i> Password
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Enter password">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Don't have an account? 
                    <a href="<?= base_url('/admin/register') ?>" class="text-indigo-600 hover:underline font-semibold">Register here</a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="<?= base_url('/') ?>" class="text-gray-600 hover:text-indigo-600 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Shop
                </a>
            </div>
        </div>

        <div class="mt-4 text-center text-white text-sm">
            <p>Default credentials: <strong>admin</strong> / <strong>admin123</strong></p>
        </div>
    </div>
</body>
</html>
