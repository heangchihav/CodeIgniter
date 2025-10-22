<?= view('admin/layout/header') ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-shopping-cart mr-2 text-indigo-600"></i>Order Management
        </h1>
        <p class="text-gray-600">Manage and track all customer orders</p>
    </div>

    <?php
    // Calculate statistics
    $totalOrders = count($orders);
    $pendingOrders = array_filter($orders, fn($o) => $o['status'] === 'pending');
    $processingOrders = array_filter($orders, fn($o) => $o['status'] === 'processing');
    $shippedOrders = array_filter($orders, fn($o) => $o['status'] === 'shipped');
    $deliveredOrders = array_filter($orders, fn($o) => $o['status'] === 'delivered');
    $cancelledOrders = array_filter($orders, fn($o) => $o['status'] === 'cancelled');
    $totalRevenue = array_sum(array_column($orders, 'total_amount'));
    ?>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold mt-1"><?= $totalOrders ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-shopping-bag text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition" onclick="filterOrders('pending')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Pending</p>
                    <p class="text-3xl font-bold mt-1"><?= count($pendingOrders) ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Processing -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition" onclick="filterOrders('processing')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Processing</p>
                    <p class="text-3xl font-bold mt-1"><?= count($processingOrders) ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-cog text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Shipped -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition" onclick="filterOrders('shipped')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Shipped</p>
                    <p class="text-3xl font-bold mt-1"><?= count($shippedOrders) ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-shipping-fast text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Delivered -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition" onclick="filterOrders('delivered')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Delivered</p>
                    <p class="text-3xl font-bold mt-1"><?= count($deliveredOrders) ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Revenue</p>
                    <p class="text-2xl font-bold mt-1">$<?= number_format($totalRevenue, 2) ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter mr-2 text-indigo-600"></i>
                Filter Orders
            </h3>
            <button onclick="filterOrders('all')" class="text-sm text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-redo mr-1"></i>Show All
            </button>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <button onclick="filterOrders('all')" id="filter-all" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-indigo-600 text-white shadow-lg">
                <i class="fas fa-th-large mr-2"></i>All Orders
            </button>
            <button onclick="filterOrders('pending')" id="filter-pending" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-yellow-50 text-yellow-700 hover:bg-yellow-100">
                <i class="fas fa-clock mr-2"></i>Pending
            </button>
            <button onclick="filterOrders('processing')" id="filter-processing" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-blue-50 text-blue-700 hover:bg-blue-100">
                <i class="fas fa-cog mr-2"></i>Processing
            </button>
            <button onclick="filterOrders('shipped')" id="filter-shipped" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-purple-50 text-purple-700 hover:bg-purple-100">
                <i class="fas fa-shipping-fast mr-2"></i>Shipped
            </button>
            <button onclick="filterOrders('delivered')" id="filter-delivered" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-green-50 text-green-700 hover:bg-green-100">
                <i class="fas fa-check-circle mr-2"></i>Delivered
            </button>
            <button onclick="filterOrders('cancelled')" id="filter-cancelled" class="px-5 py-2.5 rounded-lg font-medium transition-all bg-red-50 text-red-700 hover:bg-red-100">
                <i class="fas fa-times-circle mr-2"></i>Cancelled
            </button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">
                <span id="orderCountText">All Orders (<?= $totalOrders ?>)</span>
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="ordersTableBody">
                    <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">No orders found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50 transition order-row" data-status="<?= esc($order['status']) ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-receipt text-indigo-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900"><?= esc($order['order_number']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($order['customer_name']) ?></div>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-envelope mr-1"></i><?= esc($order['customer_email']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                <?= date('M d, Y', strtotime($order['created_at'])) ?>
                                <div class="text-xs text-gray-400"><?= date('h:i A', strtotime($order['created_at'])) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">$<?= number_format($order['total_amount'], 2) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-clock'],
                                    'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-cog'],
                                    'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'fa-shipping-fast'],
                                    'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                    'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                ];
                                $config = $statusConfig[$order['status']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-question'];
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $config['bg'] ?> <?= $config['text'] ?>">
                                    <i class="fas <?= $config['icon'] ?> mr-1"></i>
                                    <?= ucfirst(esc($order['status'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?= base_url('/admin/orders/view/' . $order['id']) ?>" 
                                   class="inline-flex items-center px-3 py-1 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition mr-2">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="<?= base_url('/admin/orders/delete/' . $order['id']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this order?')" 
                                   class="inline-flex items-center px-3 py-1 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterOrders(status) {
    const rows = document.querySelectorAll('.order-row');
    const buttons = document.querySelectorAll('[id^="filter-"]');
    const countText = document.getElementById('orderCountText');
    
    let visibleCount = 0;
    
    // Update button styles
    buttons.forEach(btn => {
        btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg');
        btn.classList.add('bg-gray-50', 'text-gray-700', 'hover:bg-gray-100');
    });
    
    const activeBtn = document.getElementById('filter-' + status);
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-50', 'text-gray-700', 'hover:bg-gray-100');
        activeBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg');
    }
    
    // Filter rows
    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update count text
    const statusLabels = {
        'all': 'All Orders',
        'pending': 'Pending Orders',
        'processing': 'Processing Orders',
        'shipped': 'Shipped Orders',
        'delivered': 'Delivered Orders',
        'cancelled': 'Cancelled Orders'
    };
    
    countText.textContent = `${statusLabels[status]} (${visibleCount})`;
}
</script>

<?= view('admin/layout/footer') ?>
