<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Methods</h1>
            <p class="text-gray-600 mt-1">Manage payment options for customers</p>
        </div>
        <a href="<?= base_url('/admin/payment-methods/create') ?>" 
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-sm">
            <i class="fas fa-plus"></i>
            Add Payment Method
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <?php if (empty($paymentMethods)): ?>
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-credit-card text-3xl text-gray-400"></i>
            </div>
            <p class="text-gray-600 text-lg font-medium mb-2">No payment methods found</p>
            <p class="text-gray-500 text-sm mb-6">Add your first payment method to get started</p>
            <a href="<?= base_url('/admin/payment-methods/create') ?>" 
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus"></i>
                Add Payment Method
            </a>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($paymentMethods as $method): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#<?= $method['display_order'] ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-semibold">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900"><?= esc($method['method_name']) ?></div>
                                    <?php if ($method['bank_name']): ?>
                                    <div class="text-xs text-gray-500"><?= esc($method['bank_name']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($method['account_name'] || $method['account_number']): ?>
                            <div class="text-sm text-gray-900">
                                <?php if ($method['account_name']): ?>
                                <div class="font-medium"><?= esc($method['account_name']) ?></div>
                                <?php endif; ?>
                                <?php if ($method['account_number']): ?>
                                <div class="text-gray-600"><?= esc($method['account_number']) ?></div>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <span class="text-sm text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($method['qr_code_url']): ?>
                            <a href="<?= esc($method['qr_code_url']) ?>" target="_blank" 
                               class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                                <i class="fas fa-qrcode"></i>
                                <span>View QR</span>
                            </a>
                            <?php else: ?>
                            <span class="text-sm text-gray-400">No QR</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?= base_url('/admin/payment-methods/toggle-status/' . $method['id']) ?>" 
                               class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-colors
                                      <?= $method['is_active'] ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' ?>">
                                <i class="fas fa-circle text-[6px] <?= $method['is_active'] ? 'text-green-600' : 'text-gray-600' ?>"></i>
                                <?= $method['is_active'] ? 'Active' : 'Inactive' ?>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?= base_url('/admin/payment-methods/edit/' . $method['id']) ?>" 
                                   class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="<?= base_url('/admin/payment-methods/delete/' . $method['id']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this payment method?')"
                                   class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 font-medium">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= view('admin/layout/footer') ?>
