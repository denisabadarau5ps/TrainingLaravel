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
    public function index()
    {
        $products = Product::all();
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
            $product = Product::where('id', $id)->first();
            $imagename = $id . '.' . $product->extension;
            if (Storage::exists($imagename)) {
                Storage::delete($imagename);
            }
            $product->delete();
            return redirect()->route('products');
        }
    }

    /**
     * Show store/edit form for a product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProductForm(Request $request, $id = null)
    {
        return Product::where('id', $id)->exists() || $id == null ? view('product-form', ['id' => $id]) : abort(404);
    }

    /**
     * Validate data from add/edit form
     * @param Request $request
     * @return array
     */
    public function validateData(Request $request)
    {
        return $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'fileToUpload' => 'required|image',
        ]);
    }

    /**
     * Edit/store a product
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, $id = null)
    {
        $validatedData = $this->validateData($request);
        $image = $request->file('fileToUpload');
        if ($id != null) {
            $product = Product::where('id', $id)->first();
            $imagename = $product->id . '.' . $product->extension;
            if (Storage::exists($imagename)) {
                Storage::delete($imagename);
            }
        } else {
            $product = new Product();
        }
        $product->title = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->extension = $image->extension();
        $product->save();

        $imagename = $product->id . '.' . $product->extension;
        $image->storeAs('public/images', $imagename);
        if ($id == null) {
            return redirect()->route('store')->with('status', 'Product saved');
        } else {
            return redirect()->route('edit', ['id' => $id])->with('status', 'Product saved');
        }
    }
}
