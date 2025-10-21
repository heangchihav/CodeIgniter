<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manage Orders</h1>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No orders found</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= esc($order['order_number']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?= esc($order['customer_name']) ?>
                            <div class="text-xs text-gray-500"><?= esc($order['customer_email']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('M d, Y', strtotime($order['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            $<?= number_format($order['total_amount'], 2) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $colorClass = $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $colorClass ?>">
                                <?= ucfirst(esc($order['status'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?= base_url('/admin/orders/view/' . $order['id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="<?= base_url('/admin/orders/delete/' . $order['id']) ?>" 
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
