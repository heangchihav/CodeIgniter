<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Shop Routes
$routes->get('/', 'Shop::index');
$routes->get('/products', 'Shop::products');
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
