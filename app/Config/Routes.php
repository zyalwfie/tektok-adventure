<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Landing', ['as' => 'landing.index']);
$routes->get('shop', 'Landing::shop', ['as' => 'landing.shop.index']);
$routes->get('shop/show/(:segment)', 'Landing::showShop/$1', ['as' => 'landing.shop.show']);

$routes->group('cart', [
    'filter' => 'login',
    'filter' => 'role:user',
], static function ($routes) {
    $routes->get('/', 'Landing::cart', ['as' => 'landing.cart.index']);
    $routes->post('add', 'Landing::addToCart', ['as' => 'landing.cart.add']);
    $routes->post('increase/(:num)', 'Landing::increaseCartQuantity/$1', ['as' => 'landing.cart.increase']);
    $routes->post('decrease/(:num)', 'Landing::decreaseCartQuantity/$1', ['as' => 'landing.cart.decrease']);
    $routes->post('(:num)', 'Landing::destroyCart/$1', ['as' => 'landing.cart.destroy']);
    $routes->get('payment/(:num)', 'Landing::payment/$1', ['as' => 'landing.cart.payment.index']);
    $routes->post('payment/create', 'Landing::paymentCreate', ['as' => 'landing.cart.payment.create']);
    $routes->post('payment/upload', 'Landing::paymentUpload', ['as' => 'landing.cart.payment.upload']);
    $routes->post('payment/update', 'Landing::paymentUpdate', ['as' => 'landing.cart.payment.update']);
    $routes->get('payment/done', 'Landing::paymentDone', ['as' => 'landing.cart.payment.done']);
});

$routes->group('dashboard', ['filter' => 'login'], static function ($routes) {

    // Admin Dashboard
    $routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('', 'Admin', ['as' => 'admin.index']);

        $routes->get('products', 'Admin::products', ['as' => 'admin.products.index']);
        $routes->get('products/create', 'Admin::createProduct', ['as' => 'admin.prodducts.create']);
        $routes->post('products/store', 'Admin::storeProduct', ['as' => 'admin.products.store']);
        $routes->get('products/edit/(:segment)', 'Admin::editProduct/$1', ['as' => 'admin.products.edit']);
        $routes->post('products/update/(:num)', 'Admin::updateProduct/$1', ['as' => 'admin.products.update']);
        $routes->post('products/destroy/(:segment)', 'Admin::destroyProduct/$1', ['as' => 'admin.products.destroy']);

        $routes->get('users', 'Admin::users', ['as' => 'admin.users.index']);
        $routes->post('users/destroy/(:segment)', 'Admin::destroyUser/$1', ['as' => 'admin.users.destroy']);

        $routes->get('orders', 'Admin::orders', ['as' => 'admin.orders.index']);
        $routes->get('orders/show/(:num)', 'Admin::showOrder/$1', ['as' => 'admin.orders.show']);
        $routes->get('orders/update/(:num)', 'Admin::updateOrder/$1', ['as' => 'admin.orders.update']);

        $routes->get('profile', 'Admin::profile', ['as' => 'admin.profile.index']);
        $routes->get('profile/edit', 'Admin::editProfile', ['as' => 'admin.profile.edit']);
        $routes->post('profile/update', 'Admin::updateProfile', ['as' => 'admin.profile.update']);
    });

    // User Dashboard
    $routes->group('user', ['filter' => 'role:user'], static function ($routes) {
        $routes->get('', 'User', ['as' => 'user.index']);

        $routes->get('orders', 'User::orders', ['as' => 'user.orders.index']);
        $routes->get('orders/show/(:num)', 'User::showOrder/$1', ['as' => 'user.orders.show']);

        $routes->get('profile', 'User::profile', ['as' => 'user.profile.index']);
        $routes->get('profile/edit', 'User::editProfile', ['as' => 'user.profile.edit']);
        $routes->post('profile/update', 'User::updateProfile', ['as' => 'user.profile.update']);
    });
});
