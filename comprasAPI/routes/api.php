<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;


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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('customer', [CustomerController::class, 'store']);
    Route::put('customer', [CustomerController::class, 'update']);
    Route::delete('customer', [CustomerController::class, 'destroy']);
    Route::get('customer', [CustomerController::class, 'index']);

    Route::get('customerType', [CustomerTypeController::class, 'index']);

    Route::post('product', [ProductController::class, 'store']);
    Route::put('product', [ProductController::class, 'update']);
    Route::delete('product', [ProductController::class, 'destroy']);
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/get', [ProductController::class, 'show']);

    Route::post('purchase', [PurchaseController::class, 'store']);
    Route::put('purchase', [PurchaseController::class, 'update']);
    Route::delete('purchase', [PurchaseController::class, 'destroy']);
    Route::get('purchase', [PurchaseController::class, 'index']);
    Route::get('purchase/get', [PurchaseController::class, 'show']);
});