<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Show login form
     */
    public function index(Request $request)
    {
        $request->session()->pull('admin');
        if($request->expectsJson()) {
            return response()->json(['success' => 'Success']);
        }
        return view('login');
    }

    /**
     * Login for admin
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if ($request->input('username') == config('admin.username')
            && $request->input('password') == config('admin.password')) {
            $request->session()->push('admin', true);
        }
    }

    /**
     * Logout for admin
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        if($request->expectsJson()) {
            return response()->json(['success' => 'Logout successfully']);
        }
        return redirect()->route('index');
    }
}
