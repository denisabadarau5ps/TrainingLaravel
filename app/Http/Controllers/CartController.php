<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show all products from cart
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', $cart)->get();
        return view('cart', ['products' => $products]);
    }

    /**
     * Add products in cart
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            if (!$request->session()->has('cart')) {
                $request->session()->put('cart', []);
            }
            $request->session()->push('cart', $id);
            return redirect()->route('index');
        }
    }

    /**
     * Remove products from cart
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $products = $request->session()->pull('cart', []);
            if (($key = array_search($id, $products)) !== false) {
                unset($products[$key]);
            }
            foreach ($products as $key => $value) {
                $request->session()->push('cart', $value);
            }
            return redirect()->route('show.cart');
        }
    }
}
