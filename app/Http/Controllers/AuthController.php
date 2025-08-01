<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request) {
        // Validate
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        // Register
        $user = User::create($fields);

        // Assign role
        if ($user->email === 'admin@gmail.com') {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user'); // optional default role
        }

        // Login
        Auth::login($user);

        // Redirect
        return redirect()->route('home');
    }

    // Login User
    public function login(Request $request) {
        // Validate
        $credentials = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);

        // Try to login the user
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'failed' => 'Login failed. Please check your email and password.'
        ]);
    }

    // Logout User
    public function logout(Request $request) {
        // Logout the user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to home
        return redirect('/');
    }
}
