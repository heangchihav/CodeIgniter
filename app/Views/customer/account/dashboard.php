<?= view('layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Account</h1>
        <p class="text-gray-600 mt-2">Welcome back, <?= esc($customer['name']) ?>!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Account Info Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 rounded-full p-3">
                    <i class="fas fa-user text-indigo-600 text-2xl"></i>
                </div>
                <h2 class="ml-4 text-xl font-semibold">Profile</h2>
            </div>
            <p class="text-gray-600 mb-4">Manage your personal information</p>
            <a href="<?= base_url('/account/profile') ?>" class="text-indigo-600 hover:underline font-semibold">
                View Profile <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Orders Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-shopping-bag text-green-600 text-2xl"></i>
                </div>
                <h2 class="ml-4 text-xl font-semibold">Orders</h2>
            </div>
            <p class="text-gray-600 mb-4">Track and view your orders</p>
            <a href="<?= base_url('/account/orders') ?>" class="text-indigo-600 hover:underline font-semibold">
                View Orders <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                </div>
                <h2 class="ml-4 text-xl font-semibold">Statistics</h2>
            </div>
            <p class="text-gray-600 mb-2">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900"><?= count($orders) ?></p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
            <a href="<?= base_url('/account/orders') ?>" class="text-indigo-600 hover:underline text-sm">View All</a>
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-shopping-bag text-4xl text-gray-300 mb-2"></i>
                            <p>No orders yet</p>
                            <a href="<?= base_url('/products') ?>" class="text-indigo-600 hover:underline mt-2 inline-block">Start Shopping</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= esc($order['order_number']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($order['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                $<?= number_format($order['total_amount'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <?= esc($order['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?= base_url('/account/orders/' . $order['id']) ?>" class="text-indigo-600 hover:underline">
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
</div>

<?= view('layout/footer') ?>
