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

        <div class="space-y-3">
            <a href="<?= base_url('/') ?>" class="block w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>
