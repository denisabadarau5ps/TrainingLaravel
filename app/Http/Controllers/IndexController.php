<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show all products that are not in cart
     * @param Request $request
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        /** @var Builder $products */
        $products = Product::whereNotIn('id', $cart)->get();
        /*if ($request->expectsJson()) {
            return response()->json(['products' => $products]);
        }*/
        return response()->json(['products' => $products]);
        //return view('index', ['products' => $products->get()]);
    }
}
