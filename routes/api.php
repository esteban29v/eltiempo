<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('user/register', [UserController::class, 'store'])->name('users.store');

Route::post('user/login', [UserController::class, 'attemptLogin'])->name('users.login');

Route::middleware('auth:sanctum')->group(function() {

    Route::apiResource('user', UserController::class)->except('store')->names('users');

    Route::apiResource('product', ProductController::class)->names('products');

    Route::apiResource('sale', SaleController::class)->names('sales');
});
