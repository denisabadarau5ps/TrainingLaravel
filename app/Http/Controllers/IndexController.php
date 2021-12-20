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
        if ($request->ajax()) {
            return response()->json($products);
        }
        return view('index', ['products' => $products]);
    }
}
