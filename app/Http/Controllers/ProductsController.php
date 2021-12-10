<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Faker\Core\File;
use Illuminate\Http\Request;

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
            $image_path = public_path('/images/') . $id . '.' . $product->extension;
            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }
            $product->delete();
            return redirect()->route('products');
        }
    }

    /**
     * Add a product in products table
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateData($request);

        $image = $request->file('fileToUpload');
        $product = Product::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'extension' => $image->extension()

        ]);

        $img = $product->id . '.' . $product->extension;
        $image->move(public_path('/images/'), $img);
        return redirect()->route('store')->with('status', 'Product added');
    }

    /**
     * Edit a product from products table
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Product $product)
    {
        $validatedData = $this->validateData($request);

        $image_path = public_path('/images/') . $product->id . '.' . $product->extension;
        if (\File::exists($image_path)) {
            \File::delete($image_path);
        }

        $image = $request->file('fileToUpload');
        $product->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'extension' => $image->extension()
        ]);

        $img = $product->id . '.' . $product->extension;
        $image->move(public_path('/images/'), $img);
        return redirect()->route('edit', ['product' => $product])->with('status', 'Product updated');
    }

    /**
     * Show store form for a product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showStoreForm()
    {
        return view('store-form');
    }

    /**
     * Show edit form for a product
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showEditForm(Product $product)
    {
        return view('edit-form', ['product' => $product]);
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
}
