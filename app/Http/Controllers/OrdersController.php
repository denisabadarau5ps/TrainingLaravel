<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Validate form data
     * @param Request $request
     * @return array
     */
    public function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required',
            'contacts' => 'required',
            'comments' => 'required'
        ]);
    }

    /**
     * Store order and send an email to shopp manager
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contacts' => 'required',
            'comments' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([ 'error' => $validator->errors()], 401);
        }
        $cart = $request->session()->get('cart');
        $products = Product::whereIn('id', $cart)->get();
        $request->session()->forget('cart');

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->contacts = $request->input('contacts');
        $customer->comments = $request->input('comments');
        $customer->save();

        $order = new Order();
        $order->total = 0;
        $customer->order()->save($order);

        foreach ($products as $product) {
            $order->products()->attach($product, [
                'product_price' => $product->price
            ]);
            $order->total += $product->price;
        }
        $customer->order()->save($order);

        Mail::to(config('mail.to.adress'))
            ->send(new Checkout($order));
    }

    /**
     * List all orders
     */
    public function index(Request $request)
    {
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->get();
        /*if($request->expectsJson()) {
            return response()->json($orders);
        }
        return view('orders', [
            'orders' => $orders
        ]);*/
        return response()->json([
            'orders' => $orders
        ]);
    }
}
