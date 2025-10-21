<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manage Products</h1>
        <a href="<?= base_url('/admin/products/create') ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Add New Product
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $product['id'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= esc($product['name']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($product['category_name']) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$<?= number_format($product['price'], 2) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $product['stock'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($product['is_active']): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        <?php else: ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?= base_url('/admin/products/edit/' . $product['id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= base_url('/admin/products/delete/' . $product['id']) ?>" 
                           onclick="return confirm('Are you sure?')" 
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
