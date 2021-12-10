<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show all products that are not in cart
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereNotIn('id', $cart)->get();
        return view('index', ['products' => $products]);
    }

    /**
     * Add products in cart
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
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
}
