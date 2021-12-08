<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function checkout(Request $request)
    {
        //validate form data
        $validatedData = $request->validate([
            'name' => 'required',
            'contacts' => 'required',
            'comments' => 'required'
        ]);
        $cart = $request->session()->get('cart');
        if (!empty($cart)) {
            $products = Product::whereIn('id', $cart)->get();
            //send mail to shopp manager
            Mail::to(config('mail.to.adress'))
                ->send(new Checkout($validatedData['name'], $validatedData['contacts'], $validatedData['comments'], $products));
            $request->session()->flush();
            return redirect('/');
        } else {
            return back()->withInput()->with('message', 'Cart cant be empty');
        }
    }
}
