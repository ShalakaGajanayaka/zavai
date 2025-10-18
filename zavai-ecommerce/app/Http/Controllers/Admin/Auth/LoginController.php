<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff') {
                $request->session()->regenerate(); // ආරක්ෂාවට session එක අලුත් කරයි.
                return redirect()->intended('/admin/dashboard'); // Admin Dashboard එකට යවයි.
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'You do not have permission to access the admin panel.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
