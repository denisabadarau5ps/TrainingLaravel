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
    public function index(Request $request, $id = 0)
    {
        /*$product = Product::where('id', $id)->first();
        if($product && $product->exists() || $id == 0) {
            if($request->expectsJson()) {
                return response()->json($product);
            } else {
                view('product-form', ['product' => $product]);
            }
        }*/
        $product = \GetCandy\Models\Product::where('id', $id)->first();
        if ($product && $product->exists()) {
            return view('product-form', [
                'id' => $id,
                'product' => $product,
            ]);
        } else {
            return view('product-form', [
                'id' => $id,
                'product' => [],
            ]);
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
            'filename' => 'required|image',
        ]);
    }

    /**
     * Edit/store a product
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, $id)
    {
        $validatedData = $this->validateData($request);
        if ($id != 0) {
            $product =  \GetCandy\Models\Product::find($id);
            $product->update([
                    'attribute_data' => [
                        'name' => new \GetCandy\FieldTypes\TranslatedText(collect([
                            'en' => new \GetCandy\FieldTypes\Text($validatedData['title']),
                        ])),
                        'description' => new \GetCandy\FieldTypes\Text($validatedData['description']),
                    ],
                ]);
            $price = $product->variants->pluck('prices')->flatten()->sortBy('price')->first();
            $price->update([
                'price' =>  $validatedData['price'],
            ]) ;
        } else {
            $product = \GetCandy\Models\Product::create([
                'product_type_id' => '1',
                'status' => 'published',
                'brand' => 'Test',
                'attribute_data' => [
                    'name' => new \GetCandy\FieldTypes\TranslatedText(collect([
                        'en' => new \GetCandy\FieldTypes\Text($validatedData['title']),
                    ])),
                    'description' => new \GetCandy\FieldTypes\Text($validatedData['description']),
                ],
            ]);
            $variant = \GetCandy\Models\ProductVariant::create([
                'product_id' => $product->id,
                'tax_class_id' => '1',
                'sku' => 'test' . $product->id,
            ]);
            \GetCandy\Models\Price::create([
                'price' => $validatedData['price'],
                'compare_price' => 0,
                'currency_id' => 1,
                'tier' => 1,
                'customer_group_id' => null,
                'priceable_type' => 'GetCandy\Models\ProductVariant',
                'priceable_id' => $variant->id,
            ]);
        }
        if($request->hasFile('filename') && $request->file('filename')->isValid()) {
            $product->clearMediaCollection('products');
            $product->addMediaFromRequest('filename')->toMediaCollection('products');
        }
        if($request->expectsJson()) {
            return response()->json(['success' => 'Product saved']);
        }
        return redirect()->route('products');
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
