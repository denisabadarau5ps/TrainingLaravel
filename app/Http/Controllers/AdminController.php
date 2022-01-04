<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show login form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        session()->pull('admin');
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
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validatedData['username'] == config('admin.username')
            && $validatedData['password'] == config('admin.password')) {
            $request->session()->push('admin', true);
            if($request->expectsJson()) {
                return response()->json(['success' => 'Success']);
            }
            return redirect()->route('products');
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
