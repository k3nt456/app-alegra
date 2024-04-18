<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Kitchen\OrdersController;
use App\Http\Controllers\Kitchen\RecipesController;
use App\Http\Controllers\Warehouse\StockController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


# Autenticación
Route::group([], function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    Route::post('/validate-register', [AuthController::class, 'register'])->name('validate-register');
    Route::post('/login-start', [AuthController::class, 'login'])->name('login-start');
});

# Base
Route::view('/home', 'layouts.home')->middleware('auth')->name('home');

# Cocina
Route::group(['prefix' => 'kitchen'], function () {
    Route::view('/', 'kitchen.kitchen')->middleware('auth')->name('kitchen');
    Route::post('/orders', [OrdersController::class, 'store'])->middleware('auth')->name('kitchen-orders');
    Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth')->name('orders');
    Route::get('/recipes', [RecipesController::class, 'index'])->middleware('auth')->name('recipes');
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
