<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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

Route::get('/', 'App\Http\Controllers\ProductsController@index')->name('index');
Route::post('/', 'App\Http\Controllers\ProductsController@addToCart')->name('index');
Route::get('/cart','App\Http\Controllers\ProductsController@showCart')->name('cart');
Route::post('/cart','App\Http\Controllers\ProductsController@removeFromCart')->name('cart');
Route::post('/checkout','App\Http\Controllers\OrdersController@checkout')->name('checkout');
Route::get('/login', 'App\Http\Controllers\LoginController@showForm')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login');
