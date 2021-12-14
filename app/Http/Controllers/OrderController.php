<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Order details after checkout
     * @param Request $request
     * @param $order
     */
    public function index(Request $request, $order)
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
}
