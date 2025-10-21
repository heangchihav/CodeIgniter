<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Customer Details</h1>
        <p class="text-gray-600 mt-2"><?= esc($customer['email']) ?></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Customer Info -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <p class="font-medium text-gray-900"><?= esc($customer['name']) ?></p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Email Address</label>
                    <p class="font-medium text-gray-900"><?= esc($customer['email']) ?></p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Phone Number</label>
                    <p class="font-medium text-gray-900"><?= esc($customer['phone'] ?? 'Not provided') ?></p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Registration Date</label>
                    <p class="font-medium text-gray-900"><?= date('M d, Y', strtotime($customer['created_at'])) ?></p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Address</label>
                    <p class="font-medium text-gray-900 whitespace-pre-line"><?= esc($customer['address'] ?? 'Not provided') ?></p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Statistics</h2>
            <div class="space-y-4">
                <div class="bg-indigo-50 rounded-lg p-4">
                    <p class="text-sm text-indigo-600 font-medium">Total Orders</p>
                    <p class="text-3xl font-bold text-indigo-900"><?= count($orders) ?></p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600 font-medium">Total Spent</p>
                    <p class="text-3xl font-bold text-green-900">
                        $<?= number_format(array_sum(array_column($orders, 'total_amount')), 2) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Order History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No orders yet</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= esc($order['order_number']) ?>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?= base_url('/admin/orders/view/' . $order['id']) ?>" class="text-indigo-600 hover:underline">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <a href="<?= base_url('/admin/customers') ?>" class="text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Back to Customers
        </a>
    </div>
</div>

<?= view('admin/layout/footer') ?>
