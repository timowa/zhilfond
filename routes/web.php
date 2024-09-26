<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => \App\Http\Middleware\ShopMiddleware::class], function () {
    Route::get('/catalog', [ShopController::class, 'catalog'])->name('shop.catalog');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::get('/createOrder', [ShopController::class, 'createOrder'])->name('shop.createOrder');
    Route::get('/orders', [ShopController::class, 'orders'])->name('shop.orders');
    Route::post('/addToCart', [ShopController::class, 'addToCart'])->name('addToCart');
});

