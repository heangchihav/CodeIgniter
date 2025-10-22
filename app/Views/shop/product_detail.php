<?= view('layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="<?= base_url('/') ?>" class="text-indigo-600 hover:underline">Home</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="<?= base_url('/products') ?>" class="text-indigo-600 hover:underline">Products</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-gray-600"><?= esc($product['name']) ?></li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Product Image Gallery -->
        <div>
            <?php if (!empty($product_images)): ?>
            <!-- Main Image Display -->
            <div class="mb-4">
                <img id="mainImage" src="<?= esc($product_images[0]['image_url']) ?>" alt="<?= esc($product['name']) ?>" 
                     class="w-full rounded-lg shadow-lg object-cover" style="height: 500px;">
            </div>

            <!-- Thumbnail Gallery -->
            <div class="grid grid-cols-4 gap-2">
                <?php foreach ($product_images as $index => $img): ?>
                <div class="cursor-pointer border-2 rounded-lg overflow-hidden hover:border-indigo-500 transition <?= $index === 0 ? 'border-indigo-500' : 'border-gray-200' ?>" 
                     onclick="changeImage('<?= esc($img['image_url']) ?>', this)">
                    <img src="<?= esc($img['image_url']) ?>" alt="Thumbnail <?= $index + 1 ?>" 
                         class="w-full h-24 object-cover">
                </div>
                <?php endforeach; ?>
            </div>

            <script>
            function changeImage(imageUrl, element) {
                document.getElementById('mainImage').src = imageUrl;
                
                // Remove active border from all thumbnails
                document.querySelectorAll('.grid.grid-cols-4 > div').forEach(div => {
                    div.classList.remove('border-indigo-500');
                    div.classList.add('border-gray-200');
                });
                
                // Add active border to clicked thumbnail
                element.classList.remove('border-gray-200');
                element.classList.add('border-indigo-500');
            }
            </script>
            <?php else: ?>
            <!-- Fallback to main product image -->
            <img src="<?= esc($product['image']) ?>" alt="<?= esc($product['name']) ?>" 
                 class="w-full rounded-lg shadow-lg">
            <?php endif; ?>
        </div>

        <!-- Product Info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= esc($product['name']) ?></h1>
            
            <!-- Category and Badges -->
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-tag mr-1"></i><?= esc($category['name']) ?>
                </span>
                
                <?php if (!empty($product['is_new'])): ?>
                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-sparkles mr-1"></i>NEW
                </span>
                <?php endif; ?>
                
                <?php if (!empty($product['is_featured'])): ?>
                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-star mr-1"></i>FEATURED
                </span>
                <?php endif; ?>
                
                <?php if (!empty($product['is_popular'])): ?>
                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-fire mr-1"></i>POPULAR
                </span>
                <?php endif; ?>
            </div>

            <!-- Price Section -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <?php if (!empty($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                    <!-- Discounted Price -->
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-4xl font-bold text-red-600">$<?= number_format($product['price'], 2) ?></span>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                            -<?= number_format($product['discount_percentage'], 0) ?>% OFF
                        </span>
                    </div>
                    <?php if (!empty($product['original_price'])): ?>
                    <div class="flex items-center gap-2">
                        <span class="text-xl text-gray-500 line-through">$<?= number_format($product['original_price'], 2) ?></span>
                        <span class="text-green-600 font-semibold">
                            Save $<?= number_format($product['original_price'] - $product['price'], 2) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Regular Price -->
                    <span class="text-4xl font-bold text-indigo-600">$<?= number_format($product['price'], 2) ?></span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed"><?= nl2br(esc($product['description'])) ?></p>
            </div>

            <!-- Product Details -->
            <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Product Details</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            <i class="fas fa-box mr-2 text-indigo-600"></i>
                            <span class="font-semibold">Stock:</span>
                        </span>
                        <span class="font-bold <?= $product['stock'] > 10 ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $product['stock'] ?> available
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            <i class="fas fa-check-circle mr-2 text-indigo-600"></i>
                            <span class="font-semibold">Status:</span>
                        </span>
                        <span class="font-bold <?= $product['is_active'] ? 'text-green-600' : 'text-gray-400' ?>">
                            <?= $product['is_active'] ? 'In Stock' : 'Out of Stock' ?>
                        </span>
                    </div>
                    
                    <?php if (!empty($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            <i class="fas fa-percentage mr-2 text-indigo-600"></i>
                            <span class="font-semibold">Discount:</span>
                        </span>
                        <span class="font-bold text-red-600">
                            <?= number_format($product['discount_percentage'], 0) ?>% OFF
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">
                            <i class="fas fa-calendar-alt mr-2 text-indigo-600"></i>
                            <span class="font-semibold">Added:</span>
                        </span>
                        <span class="text-gray-700">
                            <?= date('M d, Y', strtotime($product['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Form -->
            <form action="<?= base_url('/cart/add') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" 
                           class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-layer-group mr-3 text-indigo-600"></i>
            Related Products
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <?php if ($relatedProduct['id'] != $product['id']): ?>
                <?= view('components/product_card', ['product' => $relatedProduct, 'badgeType' => 'none']) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer') ?>
