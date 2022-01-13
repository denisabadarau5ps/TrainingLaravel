<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class Test extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::paginate(5);
        return view('pagination',compact('data'));
    }
    function get_ajax_data(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::paginate(5);
            return view('pagination_data', compact('data'))->render();
        }
    }
}
