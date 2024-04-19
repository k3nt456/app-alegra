<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kitchen\OrdersController;
use App\Http\Controllers\Kitchen\RecipesController;
use App\Http\Controllers\Warehouse\StockController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

# Autenticación
Route::group([], function () {
    Route::view('/login', 'auth.login')->name('login')->middleware('guest');
    Route::view('/register', 'auth.register')->name('register')->middleware('guest');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    Route::post('/validate-register', [AuthController::class, 'register'])->middleware('guest')->name('validate-register');
    Route::post('/login-start', [AuthController::class, 'login'])->middleware('guest')->name('login-start');
});

# Base
Route::view('/home', 'layouts.home')->middleware('auth', 'guest')->name('home');

# Cocina
Route::group(['prefix' => 'kitchen'], function () {
    Route::view('/', 'kitchen.kitchen')->middleware('auth')->name('kitchen');
    Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth')->name('orders');
    Route::get('/random-orders', [OrdersController::class, 'randomOrders'])->middleware('auth')->name('random-orders');
    Route::get('/recipes', [RecipesController::class, 'index'])->middleware('auth')->name('recipes');
    Route::post('/orders', [OrdersController::class, 'store'])->middleware('auth')->name('kitchen-orders');
});

# Bodega
Route::group(['prefix' => 'stock'], function () {
    Route::get('/', [StockController::class, 'index'])->middleware('auth')->name('stock');
    Route::get('/placeHistory', [StockController::class, 'indexPlaceHistory'])->middleware('auth')->name('place-history');
});

# Si se intenta acceder en rutas no existentes saldrá el siguiente mensaje
Route::fallback(function () {
    return [
        'timestamp' => Carbon::now()->toDateTimeString(),
        'code'      => 404,
        'status'    => false,
        'data'      => ['message' => 'Acceso restringido.']
    ];
});
