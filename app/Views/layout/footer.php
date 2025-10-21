    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">E-Shop</h3>
                    <p class="text-gray-400">Your one-stop shop for quality products at great prices.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="<?= base_url('/') ?>" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="<?= base_url('/products') ?>" class="text-gray-400 hover:text-white">Products</a></li>
                        <li><a href="<?= base_url('/cart') ?>" class="text-gray-400 hover:text-white">Cart</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> info@eshop.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +1 234 567 890</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Main St, City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> E-Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
