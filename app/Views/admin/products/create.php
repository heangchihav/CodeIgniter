<?= view('admin/layout/header') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Add New Product</h1>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?= base_url('/admin/products/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('name') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                    <input type="text" name="slug" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('slug') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                    <input type="number" name="price" step="0.01" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('price') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Original Price (for discount display)</label>
                    <input type="number" name="original_price" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('original_price') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount %</label>
                    <input type="number" name="discount_percentage" step="0.01" min="0" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('discount_percentage', 0) ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                    <input type="number" name="stock" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('stock') ?>">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Main Image URL</label>
                    <input type="url" name="image"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           value="<?= old('image') ?>">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= old('description') ?></textarea>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Images (Gallery)</label>
                <div id="image-inputs" class="space-y-2">
                    <div class="flex gap-2">
                        <input type="url" name="images[]" placeholder="Image URL 1"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <button type="button" onclick="addImageInput()" class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm">
                    <i class="fas fa-plus mr-1"></i> Add Another Image
                </button>
            </div>

            <script>
            let imageCount = 1;
            function addImageInput() {
                imageCount++;
                const container = document.getElementById('image-inputs');
                const div = document.createElement('div');
                div.className = 'flex gap-2';
                div.innerHTML = `
                    <input type="url" name="images[]" placeholder="Image URL ${imageCount}"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(div);
            }
            </script>

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
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" id="isFeatured"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_new" value="1" id="isNew"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">New Arrival</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_popular" value="1" id="isPopular"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
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
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<?= view('admin/layout/footer') ?>
