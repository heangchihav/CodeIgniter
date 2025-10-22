<?= view('admin/layout/header') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="<?= base_url('/admin/payment-methods') ?>" 
               class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Payment Method</h1>
        </div>
        <p class="text-gray-600">Update payment method details</p>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r shadow-sm mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-medium mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <form action="<?= base_url('/admin/payment-methods/update/' . $paymentMethod['id']) ?>" method="post" class="p-6">
            <?= csrf_field() ?>
            
            <div class="space-y-6">
                <!-- Method Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Payment Method Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="method_name" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., Bank Transfer, Credit Card, PayPal"
                           value="<?= old('method_name', $paymentMethod['method_name']) ?>">
                    <p class="text-xs text-gray-500 mt-1">The name customers will see</p>
                </div>

                <!-- Bank Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Bank Name
                    </label>
                    <input type="text" name="bank_name" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., Chase Bank, Wells Fargo"
                           value="<?= old('bank_name', $paymentMethod['bank_name']) ?>">
                </div>

                <!-- Account Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Account Name
                    </label>
                    <input type="text" name="account_name" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Account holder name"
                           value="<?= old('account_name', $paymentMethod['account_name']) ?>">
                </div>

                <!-- Account Number -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Account Number
                    </label>
                    <input type="text" name="account_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Bank account number"
                           value="<?= old('account_number', $paymentMethod['account_number']) ?>">
                </div>

                <!-- QR Code URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        QR Code URL
                    </label>
                    <input type="url" name="qr_code_url" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="https://example.com/qr-code.png"
                           value="<?= old('qr_code_url', $paymentMethod['qr_code_url']) ?>">
                    <p class="text-xs text-gray-500 mt-1">Upload QR code image and paste the URL here</p>
                    <?php if (!empty($paymentMethod['qr_code_url'])): ?>
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600 mb-2">Current QR Code:</p>
                        <img src="<?= esc($paymentMethod['qr_code_url']) ?>" alt="QR Code" class="w-32 h-32 object-contain border border-gray-200 rounded">
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Instructions -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Payment Instructions
                    </label>
                    <textarea name="instructions" rows="4" 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Provide detailed instructions for customers on how to complete the payment..."><?= old('instructions', $paymentMethod['instructions']) ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Step-by-step instructions for customers</p>
                </div>

                <!-- Display Order -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Display Order
                    </label>
                    <input type="number" name="display_order" min="0" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0"
                           value="<?= old('display_order', $paymentMethod['display_order']) ?>">
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                </div>

                <!-- Active Status -->
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                           <?= old('is_active', $paymentMethod['is_active']) ? 'checked' : '' ?>>
                    <label for="is_active" class="text-sm font-medium text-gray-900 cursor-pointer">
                        Active (visible to customers)
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i>
                    Update Payment Method
                </button>
                <a href="<?= base_url('/admin/payment-methods') ?>" 
                   class="flex-1 sm:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= view('admin/layout/footer') ?>
