<?= view('layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping Information</h2>

                <?php if (!session()->get('customer_logged_in')): ?>
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Already have an account? 
                        <a href="<?= base_url('/login') ?>" class="font-semibold underline">Login</a> to checkout faster
                    </p>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('/checkout/process') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        <?php if (!session()->get('customer_logged_in')): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="customer_name" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   value="<?= old('customer_name') ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="customer_email" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   value="<?= old('customer_email') ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" name="customer_phone" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   value="<?= old('customer_phone') ?>">
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="customer_name" value="<?= esc(session()->get('customer_name')) ?>">
                        <input type="hidden" name="customer_email" value="<?= esc(session()->get('customer_email')) ?>">
                        <input type="hidden" name="customer_phone" value="">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Logged in as <strong><?= esc(session()->get('customer_name')) ?></strong>
                            </p>
                        </div>
                        <?php endif; ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Address *</label>
                            <textarea name="shipping_address" rows="3" required 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= old('shipping_address') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Order Notes</label>
                            <textarea name="notes" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?= old('notes') ?></textarea>
                        </div>
                        
                        <!-- Payment Slip Upload -->
                        <div class="border-t pt-4">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-receipt mr-2 text-indigo-600"></i>
                                Upload Payment Slip (Optional)
                            </label>
                            <p class="text-xs text-gray-600 mb-3">
                                You can upload your payment slip now or later from your order details page. Supported formats: JPG, PNG, PDF (Max 5MB)
                            </p>
                            <div class="relative">
                                <input type="file" 
                                       name="payment_slip" 
                                       id="payment_slip"
                                       accept="image/jpeg,image/jpg,image/png,application/pdf"
                                       class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            </div>
                            <div id="file-preview" class="mt-3 hidden">
                                <div class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span class="text-sm text-green-800 font-medium" id="file-name"></span>
                                    <button type="button" onclick="clearFile()" class="ml-auto text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-6 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">Place Order</button>
                </form>
            </div>

            <!-- Payment Methods Section -->
            <?php if (!empty($paymentMethods)): ?>
            <div class="bg-white rounded-lg shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-credit-card mr-3 text-indigo-600"></i>
                    Payment Methods
                </h2>
                
                <div class="space-y-6">
                    <?php foreach ($paymentMethods as $method): ?>
                    <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 transition-colors">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-credit-card text-white text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= esc($method['method_name']) ?></h3>
                                
                                <?php if ($method['bank_name'] || $method['account_name'] || $method['account_number']): ?>
                                <div class="bg-gray-50 rounded-lg p-4 mb-3 space-y-2">
                                    <?php if ($method['bank_name']): ?>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-university text-gray-500 w-5"></i>
                                        <span class="font-medium text-gray-700">Bank:</span>
                                        <span class="text-gray-900"><?= esc($method['bank_name']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($method['account_name']): ?>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-user text-gray-500 w-5"></i>
                                        <span class="font-medium text-gray-700">Account Name:</span>
                                        <span class="text-gray-900"><?= esc($method['account_name']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($method['account_number']): ?>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-hashtag text-gray-500 w-5"></i>
                                        <span class="font-medium text-gray-700">Account Number:</span>
                                        <span class="text-gray-900 font-mono"><?= esc($method['account_number']) ?></span>
                                        <button onclick="copyToClipboard('<?= esc($method['account_number']) ?>')" 
                                                class="ml-2 text-indigo-600 hover:text-indigo-800 transition-colors"
                                                title="Copy account number">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($method['qr_code_url']): ?>
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Scan QR Code to Pay:</p>
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-3 inline-block">
                                        <img src="<?= esc($method['qr_code_url']) ?>" 
                                             alt="QR Code for <?= esc($method['method_name']) ?>" 
                                             class="w-48 h-48 object-contain">
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($method['instructions']): ?>
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                                    <p class="text-sm font-semibold text-blue-900 mb-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Payment Instructions:
                                    </p>
                                    <div class="text-sm text-blue-800 whitespace-pre-line"><?= esc($method['instructions']) ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Important:</strong> Please complete the payment using one of the methods above and keep your payment receipt. Your order will be processed once payment is confirmed.
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3 mb-6">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600"><?= esc($item['product']['name']) ?> x<?= $item['quantity'] ?></span>
                        <span class="text-gray-900">$<?= number_format($item['subtotal'], 2) ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-900">
                        <span>Total</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    // Create a temporary textarea element
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    
    // Select and copy the text
    textarea.select();
    document.execCommand('copy');
    
    // Remove the temporary element
    document.body.removeChild(textarea);
    
    // Show a temporary success message
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i>';
    button.classList.add('text-green-600');
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.classList.remove('text-green-600');
    }, 2000);
}

// File upload preview
document.getElementById('payment_slip')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    
    if (file) {
        // Check file size (5MB max)
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

function clearFile() {
    document.getElementById('payment_slip').value = '';
    document.getElementById('file-preview').classList.add('hidden');
}
</script>

<?= view('layout/footer') ?>
