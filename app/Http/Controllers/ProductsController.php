<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //show all products that are not in cart
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereNotIn('id', $cart)->get();
        return view('index', ['products' => $products]);
    }

    //add products in cart
    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }
        $request->session()->push('cart', $id);
        return redirect('/');
    }

    //show all products from cart
    public function showCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', $cart)->get();
        return view('cart', ['products' => $products]);
    }

    //remove products from cart
    public function removeFromCart(Request $request)
    {
        $id = $request->input('id');
        $products = $request->session()->pull('cart', []);
        if (($key = array_search($id, $products)) !== false) {
            unset($products[$key]);
        }
        foreach ($products as $key => $value) {
            $request->session()->push('cart', $value);
        }
        return redirect('/cart');
    }
}
