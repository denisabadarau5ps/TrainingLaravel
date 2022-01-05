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
    public function index(Request $request)
    {
        if (Order::where('id', $request->input('id'))->exists()) {
            $id = $request->input('id');
            $order = Order::with('products')->where('id', $id)->first();
            if($request->expectsJson()) {
                return response()->json($order);
            }
            return view('order', [
                'order' => $order,
            ]);
        } else {
            abort(404);
        }
    }
}
