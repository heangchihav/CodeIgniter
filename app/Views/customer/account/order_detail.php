<?= view('layout/header') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
                <p class="text-gray-600 mt-2">Order #<?= esc($order['order_number']) ?></p>
            </div>
            <?php if ($order['status'] === 'pending'): ?>
            <button onclick="confirmCancel()" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                <i class="fas fa-times-circle mr-2"></i> Cancel Order
            </button>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <!-- Hidden form for cancellation -->
    <form id="cancelForm" action="<?= base_url('/account/orders/cancel/' . $order['id']) ?>" method="post" style="display: none;">
        <?= csrf_field() ?>
    </form>

    <script>
    function confirmCancel() {
        if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
            document.getElementById('cancelForm').submit();
        }
    }
    </script>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Information</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-medium"><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
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
                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $colorClass ?>">
                        <?= ucfirst(esc($order['status'])) ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-bold text-lg text-indigo-600">$<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line"><?= esc($order['shipping_address']) ?></p>
            <?php if ($order['notes']): ?>
            <div class="mt-4 pt-4 border-t">
                <p class="text-sm text-gray-600"><strong>Notes:</strong></p>
                <p class="text-sm text-gray-700 mt-1"><?= esc($order['notes']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Order Items</h2>
        </div>
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
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <?php if ($item['product_image']): ?>
                            <a href="<?= base_url('/product/' . $item['product_slug']) ?>" class="flex-shrink-0">
                                <img src="<?= esc($item['product_image']) ?>" alt="<?= esc($item['product_name']) ?>" 
                                     class="w-12 h-12 rounded object-cover mr-3 hover:opacity-75 transition">
                            </a>
                            <?php endif; ?>
                            <a href="<?= base_url('/product/' . $item['product_slug']) ?>" 
                               class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                <?= esc($item['product_name']) ?>
                            </a>
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

    <div class="mt-8 flex justify-between">
        <a href="<?= base_url('/account/orders') ?>" class="text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>
        <a href="<?= base_url('/products') ?>" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
            Continue Shopping
        </a>
    </div>
</div>

<?= view('layout/footer') ?>
