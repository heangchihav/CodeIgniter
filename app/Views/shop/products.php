<?= view('layout/header') ?>

<div class="bg-gradient-to-b from-indigo-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-12">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">
                        <?php if (isset($filter)): ?>
                            <?php if ($filter === 'featured'): ?>
                                <i class="fas fa-star text-yellow-500 mr-2"></i>Featured Products
                            <?php elseif ($filter === 'new'): ?>
                                <i class="fas fa-sparkles text-green-500 mr-2"></i>New Arrivals
                            <?php elseif ($filter === 'popular'): ?>
                                <i class="fas fa-fire text-red-500 mr-2"></i>Popular Products
                            <?php elseif ($filter === 'deals'): ?>
                                <i class="fas fa-bolt text-yellow-500 mr-2"></i>Flash Deals
                            <?php else: ?>
                                <?= esc($title) ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?= esc($title) ?>
                        <?php endif; ?>
                    </h1>
                </div>
                
                <!-- View Toggle -->
                <div class="flex items-center gap-2">
                    <span class="text-xs sm:text-sm text-gray-600 hidden sm:inline">View:</span>
                    <button id="gridViewBtn" onclick="switchView('grid')" class="p-2 bg-indigo-600 text-white rounded-lg transition">
                        <i class="fas fa-th text-sm"></i>
                    </button>
                    <button id="listViewBtn" onclick="switchView('list')" class="p-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-list text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="<?= base_url('/') ?>" class="text-indigo-600 hover:underline">Home</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-600">Products</li>
                    <?php if (isset($filter)): ?>
                        <li><span class="text-gray-400">/</span></li>
                        <li class="text-gray-900 font-semibold">
                            <?= ucfirst($filter) ?>
                        </li>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-filter mr-2 text-indigo-600"></i>
                    <span class="hidden sm:inline">Filter by Category</span>
                    <span class="sm:hidden">Categories</span>
                </h3>
                <?php if (isset($_GET['category'])): ?>
                <a href="<?= base_url('/products') ?>" class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile: Horizontal Scroll -->
            <div class="overflow-x-auto scrollbar-hide sm:hidden">
                <div class="flex gap-2 pb-2">
                    <a href="<?= base_url('/products') ?>" 
                       class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap <?= !isset($_GET['category']) ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700' ?>">
                        <i class="fas fa-th-large text-xs"></i>
                        <span class="text-sm">All</span>
                    </a>
                    <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('/products?category=' . $category['id']) ?>" 
                       class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all whitespace-nowrap <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700' ?>">
                        <i class="fas fa-tag text-xs"></i>
                        <span class="text-sm"><?= esc($category['name']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Desktop: Wrapped Layout -->
            <div class="hidden sm:flex flex-wrap gap-3">
                <a href="<?= base_url('/products') ?>" 
                   class="px-5 py-2.5 rounded-lg font-medium transition-all <?= !isset($_GET['category']) ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                    <i class="fas fa-th-large mr-2"></i>All Products
                </a>
                <?php foreach ($categories as $category): ?>
                <a href="<?= base_url('/products?category=' . $category['id']) ?>" 
                   class="px-5 py-2.5 rounded-lg font-medium transition-all <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                    <i class="fas fa-tag mr-2"></i><?= esc($category['name']) ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Quick Filters -->
            <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                <h4 class="text-xs sm:text-sm font-semibold text-gray-700 mb-3">Quick Filters:</h4>
                
                <!-- Mobile: Horizontal Scroll -->
                <div class="overflow-x-auto scrollbar-hide sm:hidden">
                    <div class="flex gap-2 pb-2">
                        <a href="<?= base_url('/products/deals') ?>" 
                           class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg transition text-xs font-medium whitespace-nowrap <?= (isset($filter) && $filter === 'deals') ? 'bg-red-600 text-white shadow-lg' : 'bg-red-50 text-red-700' ?>">
                            <i class="fas fa-bolt"></i>
                            <span>Deals</span>
                        </a>
                        <a href="<?= base_url('/products/new') ?>" 
                           class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg transition text-xs font-medium whitespace-nowrap <?= (isset($filter) && $filter === 'new') ? 'bg-green-600 text-white shadow-lg' : 'bg-green-50 text-green-700' ?>">
                            <i class="fas fa-sparkles"></i>
                            <span>New</span>
                        </a>
                        <a href="<?= base_url('/products/popular') ?>" 
                           class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg transition text-xs font-medium whitespace-nowrap <?= (isset($filter) && $filter === 'popular') ? 'bg-orange-600 text-white shadow-lg' : 'bg-orange-50 text-orange-700' ?>">
                            <i class="fas fa-fire"></i>
                            <span>Popular</span>
                        </a>
                        <a href="<?= base_url('/products/featured') ?>" 
                           class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg transition text-xs font-medium whitespace-nowrap <?= (isset($filter) && $filter === 'featured') ? 'bg-yellow-600 text-white shadow-lg' : 'bg-yellow-50 text-yellow-700' ?>">
                            <i class="fas fa-star"></i>
                            <span>Featured</span>
                        </a>
                    </div>
                </div>

                <!-- Desktop: Wrapped Layout -->
                <div class="hidden sm:flex flex-wrap gap-2">
                    <a href="<?= base_url('/products/deals') ?>" 
                       class="px-4 py-2 rounded-lg transition text-sm font-medium <?= (isset($filter) && $filter === 'deals') ? 'bg-red-600 text-white shadow-lg' : 'bg-red-50 text-red-700 hover:bg-red-100' ?>">
                        <i class="fas fa-bolt mr-1"></i>Deals
                    </a>
                    <a href="<?= base_url('/products/new') ?>" 
                       class="px-4 py-2 rounded-lg transition text-sm font-medium <?= (isset($filter) && $filter === 'new') ? 'bg-green-600 text-white shadow-lg' : 'bg-green-50 text-green-700 hover:bg-green-100' ?>">
                        <i class="fas fa-sparkles mr-1"></i>New
                    </a>
                    <a href="<?= base_url('/products/popular') ?>" 
                       class="px-4 py-2 rounded-lg transition text-sm font-medium <?= (isset($filter) && $filter === 'popular') ? 'bg-orange-600 text-white shadow-lg' : 'bg-orange-50 text-orange-700 hover:bg-orange-100' ?>">
                        <i class="fas fa-fire mr-1"></i>Popular
                    </a>
                    <a href="<?= base_url('/products/featured') ?>" 
                       class="px-4 py-2 rounded-lg transition text-sm font-medium <?= (isset($filter) && $filter === 'featured') ? 'bg-yellow-600 text-white shadow-lg' : 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' ?>">
                        <i class="fas fa-star mr-1"></i>Featured
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-box-open text-8xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Products Found</h3>
                <p class="text-gray-600 mb-6">
                    We couldn't find any products matching your criteria. Try adjusting your filters.
                </p>
                <a href="<?= base_url('/products') ?>" 
                   class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>View All Products
                </a>
            </div>
        </div>
        <?php else: ?>
        
        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-6">
            <?php foreach ($products as $product): ?>
                <?= view('components/product_card', ['product' => $product]) ?>
            <?php endforeach; ?>
        </div>

        <!-- List View -->
        <div id="listView" class="hidden space-y-4">
            <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Product Image -->
                    <div class="md:w-64 h-48 md:h-auto relative flex-shrink-0">
                        <a href="<?= base_url('/product/' . $product['slug']) ?>">
                            <img src="<?= esc($product['image']) ?>" alt="<?= esc($product['name']) ?>" 
                                 class="w-full h-full object-cover">
                        </a>
                        
                        <!-- Badges on Image -->
                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                            <?php if (!empty($product['is_new'])): ?>
                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">NEW</span>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['is_popular'])): ?>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">🔥 HOT</span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                        <div class="absolute top-2 right-2">
                            <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                                -<?= number_format($product['discount_percentage'], 0) ?>%
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <a href="<?= base_url('/product/' . $product['slug']) ?>">
                                    <h3 class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition mb-2">
                                        <?= esc($product['name']) ?>
                                    </h3>
                                </a>
                                
                                <!-- Badges -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <?php if (!empty($product['is_featured'])): ?>
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                        <i class="fas fa-star"></i> Featured
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-4 line-clamp-2">
                            <?= esc($product['description']) ?>
                        </p>

                        <div class="flex items-center justify-between">
                            <div>
                                <?php if (!empty($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl font-bold text-red-600">
                                        $<?= number_format($product['price'], 2) ?>
                                    </span>
                                    <?php if (!empty($product['original_price'])): ?>
                                    <span class="text-lg text-gray-400 line-through">
                                        $<?= number_format($product['original_price'], 2) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <span class="text-2xl font-bold text-indigo-600">
                                    $<?= number_format($product['price'], 2) ?>
                                </span>
                                <?php endif; ?>
                                
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-box mr-1"></i>
                                    Stock: <span class="font-semibold <?= $product['stock'] > 10 ? 'text-green-600' : 'text-red-600' ?>">
                                        <?= $product['stock'] ?>
                                    </span>
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <a href="<?= base_url('/product/' . $product['slug']) ?>" 
                                   onclick="animateListViewClick(event, this)"
                                   class="flex items-center justify-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition hover:scale-105 active:scale-95"
                                   title="View Details">
                                    <i class="fas fa-eye text-lg"></i>
                                    <span class="ml-2 hidden md:inline">View</span>
                                </a>
                                <?php if ($product['stock'] > 0): ?>
                                <form action="<?= base_url('/cart/add') ?>" method="post" onsubmit="animateListAddToCart(event, this)">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition hover:scale-105 active:scale-95 shadow-md"
                                            title="Add to Cart">
                                        <i class="fas fa-cart-plus text-lg"></i>
                                        <span class="ml-2 hidden md:inline">Add to Cart</span>
                                    </button>
                                </form>
                                <?php else: ?>
                                <button disabled
                                        class="flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed"
                                        title="Out of Stock">
                                    <i class="fas fa-ban text-lg"></i>
                                    <span class="ml-2 hidden md:inline">Out of Stock</span>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Product Count Summary -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Showing <span class="font-semibold text-gray-900"><?= count($products) ?></span> 
                product<?= count($products) !== 1 ? 's' : '' ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Hide scrollbar for horizontal scroll */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>

<script>
// View switcher functionality
function switchView(view) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');

    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-indigo-600', 'text-white');
        gridBtn.classList.remove('bg-gray-200', 'text-gray-600');
        listBtn.classList.remove('bg-indigo-600', 'text-white');
        listBtn.classList.add('bg-gray-200', 'text-gray-600');
        localStorage.setItem('productView', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-indigo-600', 'text-white');
        listBtn.classList.remove('bg-gray-200', 'text-gray-600');
        gridBtn.classList.remove('bg-indigo-600', 'text-white');
        gridBtn.classList.add('bg-gray-200', 'text-gray-600');
        localStorage.setItem('productView', 'list');
    }
}

// Load saved view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('productView') || 'grid';
    if (savedView === 'list') {
        switchView('list');
    }
});

// Animation for list view button click
function animateListViewClick(event, link) {
    event.preventDefault();
    
    const card = link.closest('.bg-white');
    const icon = link.querySelector('i');
    
    // Animate the card
    card.classList.add('ring-4', 'ring-blue-400', 'shadow-2xl');
    link.classList.remove('border-indigo-600', 'text-indigo-600');
    link.classList.add('bg-blue-100', 'border-blue-500', 'text-blue-700');
    
    // Pulse icon
    icon.classList.add('animate-pulse');
    
    // Scale animation
    card.style.transform = 'scale(1.01)';
    
    // Navigate after animation
    setTimeout(() => {
        window.location.href = link.href;
    }, 300);
}

// Animation for list view add to cart
function animateListAddToCart(event, form) {
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
    card.style.transform = 'scale(1.01)';
    
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

<?= view('layout/footer') ?>
