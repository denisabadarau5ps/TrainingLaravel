<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //show login form
    public function show()
    {
        return view('login');
    }

    //login for admin
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validateData['username'] == config('admin.username') && $validateData['password'] == config('admin.password')) {
            return redirect()->route('products');
        }
        return back()->withInput()->with('status', 'Wrong credentials');
    }

}
