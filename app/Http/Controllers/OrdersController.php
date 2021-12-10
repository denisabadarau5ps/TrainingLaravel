<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    /**
     * Send an email to shopp manager with order details
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'contacts' => 'required',
            'comments' => 'required'
        ]);
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $products = Product::whereIn('id', $cart)->get();
            Mail::to(config('mail.to.adress'))
                ->send(new Checkout($validatedData['name'], $validatedData['contacts'], $validatedData['comments'], $products));
            $request->session()->forget('cart');
            return redirect()->route('index');
        } else {
            return back()->withInput()->with('message', 'Cart cant be empty');
        }
    }
}
