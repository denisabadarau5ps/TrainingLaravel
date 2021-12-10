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

Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');
Route::post('/', 'App\Http\Controllers\IndexController@store')->name('add.to.cart');

Route::get('/cart','App\Http\Controllers\CartController@index')->name('show.cart');
Route::post('/cart','App\Http\Controllers\CartController@remove')->name('remove.from.cart');

Route::post('/checkout','App\Http\Controllers\OrdersController@checkout')->name('checkout');

Route::get('/login', 'App\Http\Controllers\AdminController@index')->name('login.show');
Route::post('/login', 'App\Http\Controllers\AdminController@login')->name('login');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout')->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/products', 'App\Http\Controllers\ProductsController@index')->name('products');
    Route::post('/products', 'App\Http\Controllers\ProductsController@remove')->name('remove.product');

    Route::get('/edit/{product}', 'App\Http\Controllers\ProductsController@showEditForm')->name('show.edit.form');
    Route::post('/edit/{product}', 'App\Http\Controllers\ProductsController@edit')->name('edit');

    Route::get('/store', 'App\Http\Controllers\ProductsController@showStoreForm')->name('show.store.form');
    Route::post('/store', 'App\Http\Controllers\ProductsController@store')->name('store');
});

