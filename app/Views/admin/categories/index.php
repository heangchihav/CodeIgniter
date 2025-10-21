<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manage Categories</h1>
        <a href="<?= base_url('/admin/categories/create') ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Add New Category
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $category['id'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= esc($category['name']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($category['slug']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $category['product_count'] ?? 0 ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?= base_url('/admin/categories/edit/' . $category['id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('/admin/categories/delete/' . $category['id']) ?>" 
                           onclick="return confirm('Are you sure? This will delete all products in this category.')" 
                           class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?= view('admin/layout/footer') ?>
