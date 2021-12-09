<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Faker\Core\File;
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
        return redirect()->route('index');
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
        return redirect()->route('showCart');
    }

    //show all products from products table
    public function show()
    {
        $products = Product::all();
        return view('products', ['products' => $products]);
    }

    //deleye a product from products table
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $product = Product::where('id', $id)->first();
        $image_path = public_path('/images/') . $id .'.'. $product->extension;
        if (\File::exists($image_path)) {
            \File::delete($image_path);
        }
        $product->delete();
        return redirect()->route('products');
    }

    //add a product in products table
    public function store(Request $request)
    {
        //validate data
        $validatedData = $this->validateData($request);

        //save the product in products table
        $image = $request->file('fileToUpload');
        $product = Product::create([
            'title' => $validatedData['title'],
            'description' =>  $validatedData['description'],
            'price' => $validatedData['price'],
            'extension' => $image->extension()

        ]);

        //add the image in images folder
        $img = $product->id . '.' . $product->extension;
        $image->move(public_path('/images/'), $img);
        return redirect()->route('store')->with('status', 'Product added');
    }

    //edit a product from products table
    public function edit(Request $request, Product $product)
    {
        $validatedData = $this->validateData($request);

        //delete old image
        $image_path = public_path('/images/') . $product->id .'.'. $product->extension;
        if (\File::exists($image_path)) {
            \File::delete($image_path);
        }

        //update the product in products table
        $image = $request->file('fileToUpload');
        $product->update([
            'title' => $validatedData['title'],
            'description' =>  $validatedData['description'],
            'price' => $validatedData['price'],
            'extension' => $image->extension()
        ]);

        //add the image in images folder
        $img = $product->id . '.' . $product->extension;
        $image->move(public_path('/images/'), $img);
        return redirect()->route('edit', ['product' => $product])->with('status', 'Product updated');
    }

    public function showStoreForm()
    {
        return view('store');
    }

    public function showEditForm(Product $product)
    {
        return view('edit', ['product' => $product]);
    }

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
