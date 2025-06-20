<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
        // Validate the login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerate the session to avoid session fixation attacks
            $request->session()->regenerate();

            // Redirect the user to the intended page or user dashboard
            return redirect()->intended(route('user.dashboard'));  // Redirect to user dashboard
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors(['email' => 'The provided credentials are incorrect.']);
    }

    /**
     * Log the user out and redirect to the homepage.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
