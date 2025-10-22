<?= view('layout/header') ?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <i class="fas fa-check-circle text-6xl text-green-500"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-600 mb-6">Thank you for your order. Your order number is:</p>
        <div class="bg-gray-100 rounded-lg p-4 mb-6">
            <p class="text-2xl font-bold text-indigo-600"><?= esc($order['order_number']) ?></p>
        </div>

        <div class="border-t border-b py-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Details</h2>
            <div class="space-y-3">
                <?php foreach ($order['items'] as $item): ?>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600"><?= esc($item['product_name']) ?> x<?= $item['quantity'] ?></span>
                    <span class="text-gray-900">$<?= number_format($item['subtotal'], 2) ?></span>
                </div>
                <?php endforeach; ?>
                <div class="border-t pt-3 flex justify-between font-bold">
                    <span>Total</span>
                    <span>$<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>
        </div>

        <!-- Payment Reminder -->
        <?php if (empty($order['payment_slip'])): ?>
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 text-left">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-800 mb-1">Payment Required</h3>
                    <p class="text-sm text-yellow-700 mb-3">
                        Please complete your payment and upload the payment slip to process your order.
                    </p>
                    <a href="<?= base_url('/account/orders/' . $order['id']) ?>" 
                       class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-upload"></i>
                        Upload Payment Slip
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 text-left">
            <div class="flex items-start">
                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-sm font-semibold text-green-800 mb-1">Payment Slip Received</h3>
                    <p class="text-sm text-green-700">
                        Thank you! Your payment slip has been uploaded. We will verify and process your order soon.
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="space-y-3">
            <?php if (session()->get('customer_logged_in')): ?>
            <a href="<?= base_url('/account/orders/' . $order['id']) ?>" 
               class="block w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                <i class="fas fa-eye mr-2"></i>
                View Order Details
            </a>
            <?php endif; ?>
            <a href="<?= base_url('/') ?>" class="block w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>
