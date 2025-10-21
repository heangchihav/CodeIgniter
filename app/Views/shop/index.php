<?= view('layout/header') ?>

<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to E-Shop</h1>
            <p class="text-xl md:text-2xl mb-8">Discover amazing products at unbeatable prices</p>
            <a href="<?= base_url('/products') ?>" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Shop Now
            </a>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Shop by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php foreach ($categories as $category): ?>
        <a href="<?= base_url('/products?category=' . $category['id']) ?>" 
           class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
            <div class="text-4xl mb-3">
                <i class="fas fa-tag text-indigo-600"></i>
            </div>
            <h3 class="font-semibold text-gray-900"><?= esc($category['name']) ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Featured Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
        <div class="bg-white rounded-lg shadow hover:shadow-xl transition">
            <a href="<?= base_url('/product/' . $product['slug']) ?>">
                <img src="<?= esc($product['image']) ?>" alt="<?= esc($product['name']) ?>" 
                     class="w-full h-48 object-cover rounded-t-lg">
            </a>
            <div class="p-4">
                <a href="<?= base_url('/product/' . $product['slug']) ?>">
                    <h3 class="font-semibold text-gray-900 mb-2 hover:text-indigo-600"><?= esc($product['name']) ?></h3>
                </a>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?= esc($product['description']) ?></p>
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-indigo-600">$<?= number_format($product['price'], 2) ?></span>
                    <form action="<?= base_url('/cart/add') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?= view('layout/footer') ?>
