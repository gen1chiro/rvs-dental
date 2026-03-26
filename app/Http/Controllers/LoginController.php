<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view('pages.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/appointments');
        }

        return back()->withErrors([
            'email' => 'The provided credential does not match our records.'
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        // Invalidate user session
        $request->session()->invalidate();

        // Regenerate CSRF Token
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
