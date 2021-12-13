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
    public function validateData(Request $request)
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
            $customer->save();

            $order = new Order();
            $order->total = 0;
            $customer->order()->save($order);

            foreach ($products as $product) {
                $order->products()->attach($product, ['product_price' => $product->price]);
                $order->total+= $product->price;
            }
            $customer->order()->save($order);

            $request->session()->forget('customer');
            $request->session()->push('customer', $customer->id);

            Mail::to(config('mail.to.adress'))
                ->send(new Checkout($order));
            return redirect()->route('order', ['order' => $order]);
        } else {
            return back()->withInput()->with('message', 'Cart cant be empty');
        }
    }

    /**
     * Order details after checkout
     * @param Request $request
     * @param $order
     */
    public function order(Request $request, $order)
    {
        if (Order::where('id', $order)->exists() && Order::where('id', $order)->first()->customer->id == $request->session()->get('customer')[0]) {
            $order = Order::where('id', $order)->first();
            return view('order', [
                'order' => $order,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * List all orders
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders', [
            'orders' => $orders
        ]);
    }
}
