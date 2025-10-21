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
            
            <div class="mb-4">
                <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                    <?= esc($category['name']) ?>
                </span>
            </div>

            <div class="mb-6">
                <span class="text-4xl font-bold text-indigo-600">$<?= number_format($product['price'], 2) ?></span>
            </div>

            <div class="mb-6">
                <p class="text-gray-700 leading-relaxed"><?= esc($product['description']) ?></p>
            </div>

            <div class="mb-6">
                <p class="text-gray-600">
                    <i class="fas fa-box mr-2"></i>
                    <span class="font-semibold">Stock:</span> <?= $product['stock'] ?> available
                </p>
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
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <?php if ($relatedProduct['id'] != $product['id']): ?>
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition">
                    <a href="<?= base_url('/product/' . $relatedProduct['slug']) ?>">
                        <img src="<?= esc($relatedProduct['image']) ?>" alt="<?= esc($relatedProduct['name']) ?>" 
                             class="w-full h-48 object-cover rounded-t-lg">
                    </a>
                    <div class="p-4">
                        <a href="<?= base_url('/product/' . $relatedProduct['slug']) ?>">
                            <h3 class="font-semibold text-gray-900 mb-2 hover:text-indigo-600"><?= esc($relatedProduct['name']) ?></h3>
                        </a>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-indigo-600">$<?= number_format($relatedProduct['price'], 2) ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer') ?>
