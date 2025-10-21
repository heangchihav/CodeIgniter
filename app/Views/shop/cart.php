<?= view('layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
    <div class="text-center py-12 bg-white rounded-lg shadow">
        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
        <p class="text-xl text-gray-600 mb-4">Your cart is empty</p>
        <a href="<?= base_url('/products') ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            Continue Shopping
        </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <?php foreach ($cartItems as $item): ?>
                <div class="flex items-center p-6 border-b last:border-b-0">
                    <img src="<?= esc($item['product']['image']) ?>" alt="<?= esc($item['product']['name']) ?>" 
                         class="w-24 h-24 object-cover rounded">
                    
                    <div class="flex-1 ml-6">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            <a href="<?= base_url('/product/' . $item['product']['slug']) ?>" class="hover:text-indigo-600">
                                <?= esc($item['product']['name']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-600">$<?= number_format($item['product']['price'], 2) ?></p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <form action="<?= base_url('/cart/update') ?>" method="post" class="flex items-center">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $item['product']['id'] ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" 
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                   onchange="this.form.submit()">
                        </form>

                        <div class="text-right">
                            <p class="font-semibold text-gray-900">$<?= number_format($item['subtotal'], 2) ?></p>
                        </div>

                        <a href="<?= base_url('/cart/remove/' . $item['product']['id']) ?>" 
                           class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4">
                <a href="<?= base_url('/cart/clear') ?>" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash mr-2"></i> Clear Cart
                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-900">
                        <span>Total</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </div>
                </div>

                <a href="<?= base_url('/checkout') ?>" 
                   class="block w-full bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Proceed to Checkout
                </a>

                <a href="<?= base_url('/products') ?>" 
                   class="block w-full text-center text-indigo-600 mt-4 hover:underline">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= view('layout/footer') ?>
