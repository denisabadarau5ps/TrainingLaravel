<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function checkout()
    {
        //validate form data
        $validatedData = request()->validate([
            'name' => 'required',
            'contacts' => 'required',
            'comments' => 'required'
        ]);
        $cart = request()->session()->get('cart');
        $products = Product::whereIn('id', $cart)->get();

        //send mail to shopp manager
        Mail::to('test@exemple.com')
            ->send(new Checkout($validatedData['name'], $validatedData['contacts'], $validatedData['comments'], $products));
        request()->session()->flush();
        return redirect('/');
    }
}
