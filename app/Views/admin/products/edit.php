<?= view('admin/layout/header') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Product</h1>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?= base_url('/admin/products/update/' . $product['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= esc($product['name']) ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                    <input type="number" name="price" step="0.01" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= $product['price'] ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Original Price (for discount display)</label>
                    <input type="number" name="original_price" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= $product['original_price'] ?? '' ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount %</label>
                    <input type="number" name="discount_percentage" step="0.01" min="0" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= $product['discount_percentage'] ?? 0 ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                    <input type="number" name="stock" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= $product['stock'] ?>">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Main Image URL</label>
                    <input type="url" name="image"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= esc($product['image']) ?>">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= esc($product['description']) ?></textarea>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Product Tags</label>
                
                <!-- Auto-Calculate Option -->
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label class="flex items-center">
                        <input type="checkbox" name="auto_calculate_features" value="1" id="autoCalculate" checked
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                               onchange="toggleManualFeatures(this)">
                        <span class="ml-2 text-sm font-semibold text-blue-900">
                            <i class="fas fa-magic mr-1"></i> Auto-Calculate Features
                        </span>
                    </label>
                    <p class="ml-6 mt-1 text-xs text-blue-700">
                        Automatically determine Featured, New, and Popular based on product data:
                        <br>• <strong>New:</strong> Created within last 30 days
                        <br>• <strong>Featured:</strong> Discount > 15% OR Stock > 50
                        <br>• <strong>Popular:</strong> Stock between 20-80 (selling well)
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="manualFeatures">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" <?= $product['is_active'] ? 'checked' : '' ?>
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" <?= ($product['is_featured'] ?? 0) ? 'checked' : '' ?>
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="isFeatured">
                        <span class="ml-2 text-sm text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_new" value="1" <?= ($product['is_new'] ?? 0) ? 'checked' : '' ?>
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="isNew">
                        <span class="ml-2 text-sm text-gray-700">New Arrival</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_popular" value="1" <?= ($product['is_popular'] ?? 0) ? 'checked' : '' ?>
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" id="isPopular">
                        <span class="ml-2 text-sm text-gray-700">Popular</span>
                    </label>
                </div>
            </div>

            <script>
            function toggleManualFeatures(checkbox) {
                const featuredCheckbox = document.getElementById('isFeatured');
                const newCheckbox = document.getElementById('isNew');
                const popularCheckbox = document.getElementById('isPopular');
                
                if (checkbox.checked) {
                    featuredCheckbox.disabled = true;
                    newCheckbox.disabled = true;
                    popularCheckbox.disabled = true;
                    featuredCheckbox.parentElement.style.opacity = '0.5';
                    newCheckbox.parentElement.style.opacity = '0.5';
                    popularCheckbox.parentElement.style.opacity = '0.5';
                } else {
                    featuredCheckbox.disabled = false;
                    newCheckbox.disabled = false;
                    popularCheckbox.disabled = false;
                    featuredCheckbox.parentElement.style.opacity = '1';
                    newCheckbox.parentElement.style.opacity = '1';
                    popularCheckbox.parentElement.style.opacity = '1';
                }
            }

            // Initialize on page load - disable manual checkboxes since auto-calculate is checked by default
            document.addEventListener('DOMContentLoaded', function() {
                const autoCheckbox = document.getElementById('autoCalculate');
                if (autoCheckbox && autoCheckbox.checked) {
                    toggleManualFeatures(autoCheckbox);
                }
            });
            </script>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?= base_url('/admin/products') ?>" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i> Update Product
                </button>
            </div>
        </form>
    </div>

    <!-- Product Gallery Section (Separate from main form) -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Gallery</h2>
        
        <?php if (!empty($product_images)): ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <?php foreach ($product_images as $img): ?>
            <div class="relative border rounded-lg p-2">
                <img src="<?= esc($img['image_url']) ?>" alt="Product image" class="w-full h-32 object-cover rounded">
                <?php if ($img['is_primary']): ?>
                <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Primary</span>
                <?php else: ?>
                <a href="<?= base_url('/admin/products/images/set-primary/' . $product['id'] . '/' . $img['id']) ?>" 
                   class="absolute top-1 left-1 bg-gray-500 hover:bg-green-500 text-white text-xs px-2 py-1 rounded">
                    Set Primary
                </a>
                <?php endif; ?>
                <a href="<?= base_url('/admin/products/images/delete/' . $img['id']) ?>" 
                   onclick="return confirm('Delete this image?')"
                   class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-gray-500 text-sm mb-4">No gallery images yet. Add images below.</p>
        <?php endif; ?>

        <!-- Add New Image Form -->
        <div class="border-t pt-4">
            <form action="<?= base_url('/admin/products/images/add/' . $product['id']) ?>" method="post" class="flex gap-2">
                <?= csrf_field() ?>
                <input type="url" name="image_url" placeholder="Enter image URL" required
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-plus mr-1"></i> Add Image
                </button>
            </form>
        </div>
    </div>
</div>

<?= view('admin/layout/footer') ?>
