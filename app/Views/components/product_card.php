<div class="bg-white rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 group overflow-hidden relative">
    <!-- Badges -->
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
        <?php 
        // Determine which badge to show based on badge_type parameter
        $badgeType = $badgeType ?? 'all'; // Default to showing all badges
        
        // Show specific badge based on section
        if ($badgeType === 'new' && isset($product['is_new']) && $product['is_new']): ?>
            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
        <?php elseif ($badgeType === 'popular' && isset($product['is_popular']) && $product['is_popular']): ?>
            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 HOT</span>
        <?php elseif ($badgeType === 'discount' && isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-<?= number_format($product['discount_percentage']) ?>%</span>
        <?php elseif ($badgeType === 'featured' && isset($product['is_featured']) && $product['is_featured']): ?>
            <span class="bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full">⭐ FEATURED</span>
        <?php elseif ($badgeType === 'all'): ?>
            <!-- Show all badges when badge_type is 'all' or not specified -->
            <?php if (isset($product['is_new']) && $product['is_new']): ?>
            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
            <?php endif; ?>
            <?php if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-<?= number_format($product['discount_percentage']) ?>%</span>
            <?php endif; ?>
            <?php if (isset($product['is_popular']) && $product['is_popular']): ?>
            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 HOT</span>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Product Image -->
    <a href="<?= base_url('/product/' . $product['slug']) ?>" class="block relative overflow-hidden">
        <img src="<?= esc($product['image']) ?>" 
             alt="<?= esc($product['name']) ?>" 
             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
    </a>

    <!-- Product Info -->
    <div class="p-4">
        <a href="<?= base_url('/product/' . $product['slug']) ?>" class="block">
            <h3 class="font-semibold text-gray-900 mb-2 hover:text-indigo-600 transition line-clamp-2 h-12">
                <?= esc($product['name']) ?>
            </h3>
        </a>
        
        <p class="text-gray-600 text-sm mb-3 line-clamp-2 h-10"><?= esc($product['description']) ?></p>
        
        <!-- Price Section -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex flex-col">
                <?php if (isset($product['original_price']) && $product['original_price'] > 0 && $product['discount_percentage'] > 0): ?>
                <span class="text-gray-400 text-sm line-through">$<?= number_format($product['original_price'], 2) ?></span>
                <span class="text-2xl font-bold text-red-600">$<?= number_format($product['price'], 2) ?></span>
                <?php else: ?>
                <span class="text-2xl font-bold text-indigo-600">$<?= number_format($product['price'], 2) ?></span>
                <?php endif; ?>
            </div>
            
            <!-- Add to Cart Button -->
            <form action="<?= base_url('/cart/add') ?>" method="post" class="inline">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" 
                        class="bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition-all duration-200 hover:scale-110 active:scale-95 shadow-lg">
                    <i class="fas fa-cart-plus"></i>
                </button>
            </form>
        </div>

        <!-- Stock Status -->
        <?php if ($product['stock'] > 0): ?>
        <div class="flex items-center text-sm text-green-600">
            <i class="fas fa-check-circle mr-1"></i>
            <span><?= $product['stock'] ?> in stock</span>
        </div>
        <?php else: ?>
        <div class="flex items-center text-sm text-red-600">
            <i class="fas fa-times-circle mr-1"></i>
            <span>Out of stock</span>
        </div>
        <?php endif; ?>
    </div>
</div>
