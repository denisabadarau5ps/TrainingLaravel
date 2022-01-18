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
    public function index($id)
    {
        if (Order::where('id', $id)->exists()) {
            $order = Order::with('products')->where('id', $id)->first();
            /*if($request->expectsJson()) {
                return response()->json($order);
            }
            return view('order', [
                'order' => $order,
            ]);*/
            return response()->json(['order' => $order]);
        }
    }
}
