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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        /** @var Builder $products */
        $products = Product::whereNotIn('id', $cart);
        if ($request->expectsJson()) {
            return response()->json($products->paginate($request->query('pageSize', 5)));
        }
        return view('index', ['products' => $products->get()]);
    }
}
