<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $validatedData = $this->validateData($request);
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            $products = Product::whereIn('id', $cart)->get();
            $request->session()->forget('cart');

            $customer = new Customer();
            $customer->name = $validatedData['name'];
            $customer->contacts = $validatedData['contacts'];
            $customer->comments = $validatedData['comments'];
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
            if($request->expectsJson()) {
                return response()->json(['success' => 'Successfully']);
            }
            return redirect()->route('index');
        } else {
            if($request->expectsJson()) {
                return response()->json(['message' => 'Cart cant be empty']);
            }
            return redirect()->back()->withInput()->with('message','Cart cant be empty');
        }
    }

    /**
     * List all orders
     */
    public function index(Request $request)
    {
        $orders = Order::all();
        if($request->expectsJson()) {
            return response()->json($orders);
        }
        return view('orders', [
            'orders' => $orders
        ]);
    }
}
