<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Show all products from products table
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $products = \GetCandy\Models\Product::all();
        if($request->expectsJson()) {
            return response()->json($products);
        }
        return view('products', ['products' => $products]);
    }

    /**
     * Remove a product from products table
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $product = \GetCandy\Models\Product::findOrFail($id);

            $product->clearMediaCollection('products');
            $product->delete();
            if($request->expectsJson()) {
                return response()->json(['success' => 'Product deleted successfully']);
            }
            return redirect()->route('products');
        }
    }
}
