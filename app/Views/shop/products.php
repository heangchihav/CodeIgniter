<?= view('layout/header') ?>

<div class="bg-gradient-to-b from-indigo-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
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
                    <p class="text-gray-600">
                        <?php if (!empty($products)): ?>
                            Showing <?= count($products) ?> product<?= count($products) !== 1 ? 's' : '' ?>
                        <?php endif; ?>
                    </p>
                </div>
                
                <!-- View Toggle -->
                <div class="hidden md:flex items-center gap-2">
                    <span class="text-sm text-gray-600">View:</span>
                    <button id="gridViewBtn" onclick="switchView('grid')" class="p-2 bg-indigo-600 text-white rounded-lg transition">
                        <i class="fas fa-th"></i>
                    </button>
                    <button id="listViewBtn" onclick="switchView('list')" class="p-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-list"></i>
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
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-filter mr-2 text-indigo-600"></i>
                    Filter by Category
                </h3>
                <?php if (isset($_GET['category'])): ?>
                <a href="<?= base_url('/products') ?>" class="text-sm text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-times mr-1"></i>Clear Filter
                </a>
                <?php endif; ?>
            </div>
            
            <div class="flex flex-wrap gap-3">
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
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Quick Filters:</h4>
                <div class="flex flex-wrap gap-2">
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
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                                   class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <form action="<?= base_url('/cart/add') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                        <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                                    </button>
                                </form>
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
</script>

<?= view('layout/footer') ?>
