<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Order details after checkout
     * @param $order
     */
    public function index($order)
    {
        if (Order::where('id', $order)->exists()) {
            $order = Order::where('id', $order)->first();
            return view('order', [
                'order' => $order,
            ]);
        } else {
            abort(404);
        }
    }
}
