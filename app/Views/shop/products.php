<?= view('layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900"><?= esc($title) ?></h1>
    </div>

    <!-- Category Filter -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-2">
            <a href="<?= base_url('/products') ?>" 
               class="px-4 py-2 rounded-lg <?= !isset($_GET['category']) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                All
            </a>
            <?php foreach ($categories as $category): ?>
            <a href="<?= base_url('/products?category=' . $category['id']) ?>" 
               class="px-4 py-2 rounded-lg <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                <?= esc($category['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Products Grid -->
    <?php if (empty($products)): ?>
    <div class="text-center py-12">
        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
        <p class="text-xl text-gray-600">No products found</p>
    </div>
    <?php else: ?>
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
    <?php endif; ?>
</div>

<?= view('layout/footer') ?>
