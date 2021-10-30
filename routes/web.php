<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'show'])->name('login');
Route::post('login.do', [AuthController::class, 'do'])->name('login.do');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register.do', [AuthController::class, 'doRegister'])->name('register.do');

Route::get('detail/{id}', [ProductController::class, 'detail'])->name('detail');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('add.to.cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('delete.cart', [CartController::class, 'delete'])->name('delete.cart');
Route::post('reduce.qty.cart', [CartController::class, 'reduceQty'])->name('reduce.qty.cart');
Route::post('add.qty.cart', [CartController::class, 'addQty'])->name('add.qty.cart');

Route::get('history', [CartController::class, 'history'])->name('history');
Route::get('history-detail/{id}', [CartController::class, 'historyDetail'])->name('history-detail');
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');

Route::post('checkout.do', [TransactionController::class, 'doCheckout'])->name('checkout.do');
Route::post('delete.transaction', [TransactionController::class, 'delete'])->name('delete.transaction');

Route::group(['middleware' => 'auth'], function () {
    Route::get('member', [MemberController::class, 'index'])->name('member');
});