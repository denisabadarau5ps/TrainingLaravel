<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //show all products that are not in cart
    public function index()
    {
        if (request()->has('id')) {
            //add products in cart
            $product_id = request('id');
            if (!request()->session()->has('cart')) {
                request()->session()->put('cart', []);
            }
            request()->session()->push('cart', $product_id);
        }
        $cart = request()->session()->get('cart', []);
        $products = Product::whereNotIn('id', $cart)->get();
        return view('index', ['products' => $products]);
    }
}
