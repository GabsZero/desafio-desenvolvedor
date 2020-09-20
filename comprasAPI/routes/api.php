<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;


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

    Route::post('product', [ProductController::class, 'store']);
    Route::put('product', [ProductController::class, 'update']);
    Route::delete('product', [ProductController::class, 'destroy']);
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/get', [ProductController::class, 'show']);
});