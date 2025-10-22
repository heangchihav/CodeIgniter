<?= view('admin/layout/header') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Banner</h1>
    </div>

    <?php if (session()->get('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?= base_url('/admin/banners/update/' . $banner['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" value="<?= old('title', $banner['title']) ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                <textarea name="subtitle" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= old('subtitle', $banner['subtitle']) ?></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image (Recommended: 1920x600px)</label>
                <div class="mb-4">
                    <img src="<?= base_url('uploads/banners/' . $banner['image']) ?>" 
                         alt="Current banner" 
                         class="max-w-full h-48 object-cover rounded-lg">
                    <p class="text-sm text-gray-500 mt-2">Current image</p>
                </div>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       onchange="previewImage(event)">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg">
                    <p class="text-sm text-gray-500 mt-2">New image preview</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                    <input type="text" name="button_text" value="<?= old('button_text', $banner['button_text']) ?>" 
                           placeholder="e.g., Shop Now" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                    <input type="text" name="button_link" value="<?= old('button_link', $banner['button_link']) ?>" 
                           placeholder="e.g., /products" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Order *</label>
                    <input type="number" name="display_order" value="<?= old('display_order', $banner['display_order']) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                           required>
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="flex items-center mt-3">
                        <input type="checkbox" name="is_active" value="1" <?= $banner['is_active'] ? 'checked' : '' ?> 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Active</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?= base_url('/admin/banners') ?>" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i> Update Banner
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>

<?= view('admin/layout/footer') ?>
