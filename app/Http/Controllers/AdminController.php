<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //show login form
    public function show()
    {
        return view('login');
    }

    //login for admin
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validatedData['username'] == config('admin.username') && $validatedData['password'] == config('admin.password')) {
            $request->session()->push('admin', true);
            return redirect()->route('products');
        }
        return back()->withInput()->with('status', 'Wrong credentials');
    }

    //logout for admin
    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect()->route('index');
    }
}
