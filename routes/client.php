<?php

// Website có các trang là:
//      Trang chủ
//      Giới thiệu
//      Sản phẩm
//      Chi tiết sản phẩm
//      Liên hệ

// Để định nghĩa được, điều đầu tiên làm là phải tạo Controller trước
// Tiếp theo, khai function tương ứng để xử lý
// Bước cuối, định nghĩa đường dẫn

// HTTP Method: get, post, put (path), delete, option, head

use Duchuy\Php2\Controllers\Client\AboutController;
use Duchuy\Php2\Controllers\Client\CartController;
use Duchuy\Php2\Controllers\Client\ContactController;
use Duchuy\Php2\Controllers\Client\HomeController;
use Duchuy\Php2\Controllers\Client\AuthController;
use Duchuy\Php2\Controllers\Client\OrderController;
use Duchuy\Php2\Controllers\Client\ProductController;

$router->get('/',                  HomeController::class       . '@index');
$router->get('/about',             AboutController::class      . '@index');

$router->get('/contact',           ContactController::class    . '@index');
$router->post('/contact/store',    ContactController::class    . '@store');

$router->get('/products',          ProductController::class    . '@products');
$router->get('/products/{id}',     ProductController::class    . '@detail');

$router->get('/login',                                  AuthController::class . '@showFormLogin');
$router->post('/handle-login',                          AuthController::class . '@handleLogin');
$router->get('/logout',                                 AuthController::class . '@logout');
$router->get('/register',                               AuthController::class . '@authRegister');
$router->post('/handle-register',                       AuthController::class . '@handleRegister');
$router->get('/active-account/token/{token}',           AuthController::class . '@activeAccount');
$router->get('/forgot-password',                        AuthController::class . '@showForgotPassword');
$router->post('/handle-forgot-password',                AuthController::class . '@handleForgotPassword');
$router->get('/reset/{token}',                          AuthController::class . '@showFormResetPassword');
$router->post('/handle-reset-password/{token}',         AuthController::class . '@handleFormResetPassword');

$router->get('cart/add',                CartController::class . '@add');
$router->get('cart/quantityInc',        CartController::class . '@quantityInc');
$router->get('cart/quantityDec',        CartController::class . '@quantityDec');
$router->get('cart/remove',             CartController::class . '@remove');
$router->get('cart/detail',             CartController::class . '@detail');

$router->post('order/checkout',     OrderController::class . '@checkout');
