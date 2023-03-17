<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', [CustomerController::class, 'index'])->name('welcome');

Route::get('/casher', [CustomerController::class, 'index'])->name('welcome');

Route::post('/casher', [CustomerController::class, 'search']);

Route::get('/table/{table}', [CustomerController::class, 'seat']);

Route::post('/table/{table}', [CustomerController::class, 'find']);

Route::post('/table/{table}/leave', [CustomerController::class, 'leave']);

Route::post('/table/{table}/add/dish/{dish}', [CustomerController::class, 'add']);

Route::delete('/order/{order}/delete', [CustomerController::class, 'delete']);

Route::get('/order', [OrderController::class, 'index'])->name('kitchens.order');

Route::delete('/order/{order}/cancel', [OrderController::class, 'delete']);

Route::get('/order/{order}/approve', [OrderController::class, 'approve']);

Route::get('/order/{order}/ready', [OrderController::class, 'ready']);

Auth::routes();

Route::resource('/dishes', DishController::class);
