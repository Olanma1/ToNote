<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/cart', [CartsController::class, 'addProductsToCart'])->name('add.cart');
    Route::get('/cart-products', [CartsController::class, 'getUserCartProducts'])->name('get.cart.products');
    Route::post('/order', [OrderController::class, 'storeOrder'])->name('user.order');
    Route::delete('/cart/{id}', [CartsController::class, 'removeProductFromCart'])->name('remove.product');
    Route::get('/allProducts', [ProductsController::class, 'getAllProducts'])->name('products');
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::get('/user',  function (Request $request) {
    return $request->user();
    });

});
Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
