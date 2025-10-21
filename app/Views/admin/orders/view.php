<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
        <p class="text-gray-600 mt-2">Order #<?= esc($order['order_number']) ?></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Information</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-medium"><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-bold text-lg text-indigo-600">$<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
            <div class="space-y-2 text-sm">
                <div>
                    <span class="text-gray-600">Name:</span>
                    <p class="font-medium"><?= esc($customer['name']) ?></p>
                </div>
                <div>
                    <span class="text-gray-600">Email:</span>
                    <p class="font-medium"><?= esc($customer['email']) ?></p>
                </div>
                <div>
                    <span class="text-gray-600">Phone:</span>
                    <p class="font-medium"><?= esc($customer['phone'] ?? 'N/A') ?></p>
                </div>
                <div class="pt-2">
                    <a href="<?= base_url('/admin/customers/view/' . $customer['id']) ?>" class="text-indigo-600 hover:underline text-sm">
                        View Customer Profile <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
            <form action="<?= base_url('/admin/orders/update-status/' . $order['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
        <p class="text-sm text-gray-700 whitespace-pre-line"><?= esc($order['shipping_address']) ?></p>
        <?php if ($order['notes']): ?>
        <div class="mt-4 pt-4 border-t">
            <p class="text-sm text-gray-600 font-semibold">Order Notes:</p>
            <p class="text-sm text-gray-700 mt-1"><?= esc($order['notes']) ?></p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Order Items</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($order_items as $item): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <?php if ($item['product_image']): ?>
                            <img src="<?= esc($item['product_image']) ?>" alt="<?= esc($item['product_name']) ?>" 
                                 class="w-12 h-12 rounded object-cover mr-3">
                            <?php endif; ?>
                            <span class="text-sm font-medium text-gray-900"><?= esc($item['product_name']) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $<?= number_format($item['price'], 2) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= $item['quantity'] ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                        $<?= number_format($item['subtotal'], 2) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                        Total:
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-indigo-600">
                        $<?= number_format($order['total_amount'], 2) ?>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-6">
        <a href="<?= base_url('/admin/orders') ?>" class="text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>
    </div>
</div>

<?= view('admin/layout/footer') ?>
