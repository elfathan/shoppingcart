<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'doRegister'])->name('register');
Route::post('login', [AuthController::class, 'do'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('product', [ProductController::class, 'product'])->name('product');
Route::get('product-detail/{id}', [ProductController::class, 'productDetail'])->name('detail');

Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::post('add.to.cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('delete.cart', [CartController::class, 'delete'])->name('delete.cart');
Route::post('reduce.qty.cart', [CartController::class, 'reduceQty'])->name('reduce.qty.cart');
Route::post('add.qty.cart', [CartController::class, 'addQty'])->name('add.qty.cart');

Route::get('history', [CartController::class, 'getHistory'])->name('history');
Route::get('history-detail/{id}', [CartController::class, 'historyDetail'])->name('history-detail');

Route::post('checkout', [TransactionController::class, 'doCheckout'])->name('checkout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('member', [MemberController::class, 'index'])->name('member');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
