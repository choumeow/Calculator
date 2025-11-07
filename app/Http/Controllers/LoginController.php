<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If user is already logged in, redirect to welcome page
        if (Auth::check()) {
            return redirect()->route('welcome');
        }
        
        return view('login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate using username instead of email
        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();

            return redirect()->route('welcome')->with('success', 'Login successful!');
        }

        throw ValidationException::withMessages([
            'username' => ['Username or Password invalid.'],
        ]);
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}

