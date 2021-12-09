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
Route::post('/', 'App\Http\Controllers\ProductsController@addToCart')->name('addCart');

Route::get('/cart','App\Http\Controllers\ProductsController@showCart')->name('showCart');
Route::post('/cart','App\Http\Controllers\ProductsController@removeFromCart')->name('removeFromCart');

Route::post('/checkout','App\Http\Controllers\OrdersController@checkout')->name('checkout');

Route::get('/login', 'App\Http\Controllers\AdminController@show')->name('loginShow');
Route::post('/login', 'App\Http\Controllers\AdminController@login')->name('login');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout')->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', 'App\Http\Controllers\ProductsController@show')->name('products');
    Route::post('/products', 'App\Http\Controllers\ProductsController@delete')->name('delete');

    Route::get('/edit', 'App\Http\Controllers\ProductsController@showEditForm')->name('showEditForm');
    //Route::post('/edit', 'App\Http\Controllers\ProductsController@edit')->name('edit');

    Route::get('/store', 'App\Http\Controllers\ProductsController@showStoreForm')->name('showStoreForm');
    Route::post('/store', 'App\Http\Controllers\ProductsController@store')->name('store');
});

