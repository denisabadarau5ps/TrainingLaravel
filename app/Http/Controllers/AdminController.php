<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show login form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Login for admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Logout for admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect()->route('index');
    }
}
