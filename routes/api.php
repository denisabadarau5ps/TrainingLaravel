<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['web']], function () {
    Route::get('index', 'App\Http\Controllers\IndexController@index');
    Route::get('cart', 'App\Http\Controllers\CartController@index');
    Route::get('products','App\Http\Controllers\ProductsController@index');
    Route::get('orders','App\Http\Controllers\OrdersController@index');
    Route::get('order/{id}', 'App\Http\Controllers\OrderController@index');

    Route::post('index', 'App\Http\Controllers\CartController@store');
    Route::post('cart', 'App\Http\Controllers\CartController@remove');
    Route::post('checkout', 'App\Http\Controllers\OrdersController@checkout');
    Route::post('login', 'App\Http\Controllers\AdminController@login');
    Route::post('products', 'App\Http\Controllers\ProductsController@remove');

});
