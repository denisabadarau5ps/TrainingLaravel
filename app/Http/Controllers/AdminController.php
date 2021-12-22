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
        session()->pull('admin');
        return response()->json(['success' => 'Success']);
    }

    /**
     * Login for admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validatedData['username'] == config('admin.username')
            && $validatedData['password'] == config('admin.password')) {
            $request->session()->push('admin', true);
            return response()->json(['success' => 'Success']);
        }
    }

    /**
     * Logout for admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->forget('admin');
        return redirect()->route('index');
    }
}
