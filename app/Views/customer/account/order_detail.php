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

    <!-- Payment Slip Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-receipt mr-2 text-indigo-600"></i>
            Payment Slip
        </h2>
        
        <?php if (isset($order['payment_slip']) && !empty($order['payment_slip'])): ?>
            <!-- Display existing payment slip -->
            <div class="space-y-4">
                <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
                    <?php 
                    $fileExt = pathinfo($order['payment_slip'], PATHINFO_EXTENSION);
                    $isPdf = strtolower($fileExt) === 'pdf';
                    ?>
                    
                    <?php if ($isPdf): ?>
                        <!-- PDF Preview -->
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-pdf text-3xl text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">PDF Document</p>
                                <p class="text-xs text-gray-500">Payment slip uploaded</p>
                            </div>
                            <a href="<?= base_url($order['payment_slip']) ?>" 
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-eye"></i>
                                View
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Image Preview -->
                        <img src="<?= base_url($order['payment_slip']) ?>" 
                             alt="Payment Slip" 
                             class="w-full max-w-md mx-auto rounded-lg object-contain max-h-96 cursor-pointer hover:opacity-90 transition"
                             onclick="window.open('<?= base_url($order['payment_slip']) ?>', '_blank')">
                    <?php endif; ?>
                </div>
                
                <!-- Upload new slip form -->
                <?php if ($order['status'] !== 'cancelled'): ?>
                <div class="pt-4 border-t">
                    <p class="text-sm text-gray-600 mb-3">Want to upload a different payment slip?</p>
                    <form action="<?= base_url('/account/orders/upload-slip/' . $order['id']) ?>" 
                          method="post" 
                          enctype="multipart/form-data"
                          id="uploadSlipForm">
                        <?= csrf_field() ?>
                        <div class="flex gap-3">
                            <input type="file" 
                                   name="payment_slip" 
                                   id="payment_slip_update"
                                   accept="image/jpeg,image/jpg,image/png,application/pdf"
                                   required
                                   class="flex-1 px-4 py-2 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer text-sm">
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors whitespace-nowrap">
                                <i class="fas fa-upload mr-2"></i>
                                Replace
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG, or PDF (Max 5MB)</p>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Upload payment slip form -->
            <?php if ($order['status'] !== 'cancelled'): ?>
            <div class="space-y-4">
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Action Required:</strong> Please upload your payment slip to confirm your payment.
                    </p>
                </div>
                
                <form action="<?= base_url('/account/orders/upload-slip/' . $order['id']) ?>" 
                      method="post" 
                      enctype="multipart/form-data"
                      id="uploadSlipForm">
                    <?= csrf_field() ?>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">
                            Select Payment Slip
                        </label>
                        <input type="file" 
                               name="payment_slip" 
                               id="payment_slip_new"
                               accept="image/jpeg,image/jpg,image/png,application/pdf"
                               required
                               class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        <p class="text-xs text-gray-500">Supported formats: JPG, PNG, PDF (Max 5MB)</p>
                        
                        <div id="slip-preview" class="hidden mt-3">
                            <div class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span class="text-sm text-green-800 font-medium" id="slip-file-name"></span>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-upload mr-2"></i>
                            Upload Payment Slip
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="text-center py-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                    <i class="fas fa-ban text-2xl text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-600 font-medium">Order Cancelled</p>
                <p class="text-xs text-gray-500 mt-1">Payment slip upload is not available for cancelled orders</p>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
    // File preview for new upload
    document.getElementById('payment_slip_new')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('slip-preview');
        const fileName = document.getElementById('slip-file-name');
        
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                e.target.value = '';
                preview.classList.add('hidden');
                return;
            }
            fileName.textContent = file.name;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    });
    </script>

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
