<div class="bg-white rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 group overflow-hidden relative">
    <!-- Badges -->
    <div class="absolute top-2 left-2 sm:top-3 sm:left-3 z-10 flex flex-col gap-1 sm:gap-2">
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
             class="w-full h-40 sm:h-64 object-cover group-hover:scale-110 transition-transform duration-500">
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
    </a>

    <!-- Product Info -->
    <div class="p-2 sm:p-4">
        <a href="<?= base_url('/product/' . $product['slug']) ?>" class="block">
            <h3 class="font-medium text-xs sm:text-base text-gray-900 mb-1 sm:mb-2 hover:text-indigo-600 transition line-clamp-2 leading-tight sm:leading-normal">
                <?= esc($product['name']) ?>
            </h3>
        </a>
        
        <!-- Price Section -->
        <div class="mb-1.5 sm:mb-3">
            <div class="flex flex-col">
                <?php if (isset($product['original_price']) && $product['original_price'] > 0 && $product['discount_percentage'] > 0): ?>
                <span class="text-gray-400 text-[10px] sm:text-sm line-through">$<?= number_format($product['original_price'], 2) ?></span>
                <span class="text-base sm:text-2xl font-bold text-red-600">$<?= number_format($product['price'], 2) ?></span>
                <?php else: ?>
                <span class="text-base sm:text-2xl font-bold text-indigo-600">$<?= number_format($product['price'], 2) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Stock Status - Hidden on mobile, shown on tablet+ -->
        <div class="hidden sm:block mb-3">
            <?php if ($product['stock'] > 0): ?>
            <div class="flex items-center text-sm text-green-600">
                <i class="fas fa-check-circle mr-1 text-xs"></i>
                <span><?= $product['stock'] ?> in stock</span>
            </div>
            <?php else: ?>
            <div class="flex items-center text-sm text-red-600">
                <i class="fas fa-times-circle mr-1 text-xs"></i>
                <span>Out of stock</span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-1 sm:gap-2">
            <!-- View Details Button -->
            <a href="<?= base_url('/product/' . $product['slug']) ?>" 
               onclick="animateViewClick(event, this)"
               class="flex-1 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 p-1.5 sm:p-3 rounded sm:rounded-lg font-medium transition-all duration-200 hover:scale-105 active:scale-95"
               title="View Details">
                <i class="fas fa-eye text-sm sm:text-lg"></i>
            </a>
            
            <!-- Add to Cart Button -->
            <?php if ($product['stock'] > 0): ?>
            <form action="<?= base_url('/cart/add') ?>" method="post" class="flex-1" onsubmit="animateAddToCart(event, this)">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" 
                        class="w-full flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white p-1.5 sm:p-3 rounded sm:rounded-lg font-medium transition-all duration-200 hover:scale-105 active:scale-95 shadow-md"
                        title="Add to Cart">
                    <i class="fas fa-cart-plus text-sm sm:text-lg"></i>
                </button>
            </form>
            <?php else: ?>
            <button disabled
                    class="flex-1 flex items-center justify-center bg-gray-300 text-gray-500 p-1.5 sm:p-3 rounded sm:rounded-lg font-medium cursor-not-allowed"
                    title="Out of Stock">
                <i class="fas fa-ban text-sm sm:text-lg"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function animateViewClick(event, link) {
    event.preventDefault();
    
    const card = link.closest('.bg-white');
    const icon = link.querySelector('i');
    
    // Animate the card
    card.classList.add('ring-4', 'ring-blue-400', 'shadow-2xl');
    link.classList.remove('bg-gray-100');
    link.classList.add('bg-blue-100');
    
    // Pulse icon
    icon.classList.add('animate-pulse');
    
    // Scale animation
    card.style.transform = 'scale(1.02)';
    
    // Navigate after animation
    setTimeout(() => {
        window.location.href = link.href;
    }, 300);
}

function animateAddToCart(event, form) {
    event.preventDefault();
    
    const button = form.querySelector('button');
    const card = form.closest('.bg-white');
    const icon = button.querySelector('i');
    
    // Disable button temporarily
    button.disabled = true;
    
    // Animate the card
    card.classList.add('ring-4', 'ring-green-400', 'shadow-2xl');
    
    // Animate the icon
    icon.classList.remove('fa-cart-plus');
    icon.classList.add('fa-check');
    button.classList.remove('bg-indigo-600');
    button.classList.add('bg-green-600');
    
    // Scale animation
    card.style.transform = 'scale(1.02)';
    
    // Submit via AJAX to prevent page reload
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update cart count if available
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.cartCount) {
                cartCount.textContent = data.cartCount;
            }
            
            // Show success toast
            if (typeof showToast === 'function') {
                showToast(data.message || 'Product added to cart!', 'success');
            }
        } else {
            // Show error toast
            if (typeof showToast === 'function') {
                showToast(data.message || 'Failed to add product', 'error');
            }
        }
        
        // Reset animation
        setTimeout(() => {
            card.classList.remove('ring-4', 'ring-green-400', 'shadow-2xl');
            card.style.transform = 'scale(1)';
            icon.classList.remove('fa-check');
            icon.classList.add('fa-cart-plus');
            button.classList.remove('bg-green-600');
            button.classList.add('bg-indigo-600');
            button.disabled = false;
        }, 1000);
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof showToast === 'function') {
            showToast('Failed to add product to cart', 'error');
        }
        
        // Reset animation
        card.classList.remove('ring-4', 'ring-green-400', 'shadow-2xl');
        card.style.transform = 'scale(1)';
        icon.classList.remove('fa-check');
        icon.classList.add('fa-cart-plus');
        button.classList.remove('bg-green-600');
        button.classList.add('bg-indigo-600');
        button.disabled = false;
    });
}
</script>
