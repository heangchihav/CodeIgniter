<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manage Banners</h1>
        <a href="<?= base_url('/admin/banners/create') ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Add New Banner
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtitle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($banners)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-image text-6xl text-gray-300 mb-4"></i>
                            <p class="text-lg">No banners found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($banners as $banner): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="<?= base_url('uploads/banners/' . $banner['image']) ?>" 
                                     alt="<?= esc($banner['title']) ?>" 
                                     class="h-16 w-24 object-cover rounded">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?= esc($banner['title']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500"><?= esc($banner['subtitle']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $banner['display_order'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="<?= base_url('/admin/banners/toggle/' . $banner['id']) ?>" 
                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $banner['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $banner['is_active'] ? 'Active' : 'Inactive' ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="<?= base_url('/admin/banners/edit/' . $banner['id']) ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= base_url('/admin/banners/delete/' . $banner['id']) ?>" 
                                   onclick="return confirm('Are you sure?')" 
                                   class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('admin/layout/footer') ?>
