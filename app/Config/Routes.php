<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Shop Routes
$routes->get('/', 'Shop::index');
$routes->get('/products', 'Shop::products');
$routes->get('/products/featured', 'Shop::featured');
$routes->get('/products/new', 'Shop::newArrivals');
$routes->get('/products/popular', 'Shop::popular');
$routes->get('/products/deals', 'Shop::deals');
$routes->get('/product/(:segment)', 'Shop::product/$1');
$routes->get('/search', 'Shop::search');

// Cart Routes
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/add', 'Cart::add');
$routes->post('/cart/update', 'Cart::update');
$routes->get('/cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('/cart/clear', 'Cart::clear');

// Checkout Routes
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/process', 'Checkout::process');
$routes->get('/checkout/success/(:num)', 'Checkout::success/$1');

// Customer Authentication Routes
$routes->get('/login', 'Customer\Auth::login');
$routes->post('/login', 'Customer\Auth::loginPost');
$routes->get('/register', 'Customer\Auth::register');
$routes->post('/register', 'Customer\Auth::registerPost');
$routes->get('/logout', 'Customer\Auth::logout');

// Customer Account Routes (Protected)
$routes->group('account', ['filter' => 'customerauth'], function($routes) {
    $routes->get('/', 'Customer\Account::index');
    $routes->get('orders', 'Customer\Account::orders');
    $routes->get('orders/(:num)', 'Customer\Account::orderDetail/$1');
    $routes->post('orders/cancel/(:num)', 'Customer\Account::cancelOrder/$1');
    $routes->post('orders/upload-slip/(:num)', 'Customer\Account::uploadPaymentSlip/$1');
    $routes->get('profile', 'Customer\Account::profile');
    $routes->post('profile/update', 'Customer\Account::updateProfile');
});

// Admin Authentication Routes
$routes->get('/admin/login', 'Admin\Auth::login');
$routes->post('/admin/login', 'Admin\Auth::loginPost');
$routes->get('/admin/register', 'Admin\Auth::register');
$routes->post('/admin/register', 'Admin\Auth::registerPost');
$routes->get('/admin/logout', 'Admin\Auth::logout');

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'adminauth'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Products
    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/create', 'Admin\Products::create');
    $routes->post('products/store', 'Admin\Products::store');
    $routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Products::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\Products::delete/$1');
    
    // Product Images - More specific routes first
    $routes->post('products/images/add/(:num)', 'Admin\Products::addImage/$1');
    $routes->get('products/images/delete/(:num)', 'Admin\Products::deleteImage/$1');
    $routes->get('products/images/set-primary/(:num)/(:num)', 'Admin\Products::setPrimaryImage/$1/$2');
    
    // Categories
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');
    
    // Banners
    $routes->get('banners', 'Admin\Banners::index');
    $routes->get('banners/create', 'Admin\Banners::create');
    $routes->post('banners/store', 'Admin\Banners::store');
    $routes->get('banners/edit/(:num)', 'Admin\Banners::edit/$1');
    $routes->post('banners/update/(:num)', 'Admin\Banners::update/$1');
    $routes->get('banners/delete/(:num)', 'Admin\Banners::delete/$1');
    $routes->get('banners/toggle/(:num)', 'Admin\Banners::toggleStatus/$1');
    
    // Orders
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/view/(:num)', 'Admin\Orders::view/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');
    $routes->get('orders/delete/(:num)', 'Admin\Orders::delete/$1');
    
    // Customers
    $routes->get('customers', 'Admin\Customers::index');
    $routes->get('customers/view/(:num)', 'Admin\Customers::view/$1');
    $routes->get('customers/delete/(:num)', 'Admin\Customers::delete/$1');
    
    // Payment Methods
    $routes->get('payment-methods', 'Admin\PaymentMethods::index');
    $routes->get('payment-methods/create', 'Admin\PaymentMethods::create');
    $routes->post('payment-methods/store', 'Admin\PaymentMethods::store');
    $routes->get('payment-methods/edit/(:num)', 'Admin\PaymentMethods::edit/$1');
    $routes->post('payment-methods/update/(:num)', 'Admin\PaymentMethods::update/$1');
    $routes->get('payment-methods/delete/(:num)', 'Admin\PaymentMethods::delete/$1');
    $routes->get('payment-methods/toggle-status/(:num)', 'Admin\PaymentMethods::toggleStatus/$1');
});
