<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Show store/edit form for a product
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        if(Product::where('id', $id)->exists() || $id == 0) {
            if($request->expectsJson()) {
                return response()->json(['success' => 'Success']);
            } else {
                view('product-form', ['id' => $id]);
            }
        }
    }

    /**
     * Validate data from add/edit form
     * @param Request $request
     * @return array
     */
    public function validateData(Request $request): array
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
    public function save(Request $request)
    {
        $validatedData = $this->validateData($request);
        $id = $request->input('id');
        $image = $request->file('fileToUpload');
        if ($id != 0) {
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
            if($request->expectsJson()) {
                return response()->json(['success' => 'Product saved']);
            }
            return redirect()->route('store')
                ->with('status', 'Product saved');
        } else {
            if($request->expectsJson()) {
                return response()->json(['succes' => 'Product saved']);
            }
            return redirect()->route('edit', ['id' => $id])
                ->with('status', 'Product saved');
        }
    }

    /**
     * Show details about a product
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function show($id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::with('ratings')
                ->where('id', $id)
                ->first();
            return view('product-details', [
                'product' => $product
            ]);
        } else {
            abort(404);
        }
    }
}
