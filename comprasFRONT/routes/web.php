<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientesController;

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

Route::view('/login', 'login')->name('login');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::middleware(['auth.api'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::prefix('cliente')->group(function(){
        Route::get('/', [ClientesController::class, 'create'])->name('cliente.create');
        Route::post('/', [ClientesController::class, 'store'])->name('cliente.store');
    });
});

