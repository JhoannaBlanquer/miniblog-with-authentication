<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Handle user registration (form)
    public function register(Request $request)
    {
        // Validate request
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Create user
        $user = $this->createUser($fields);

        // Log in the user
        Auth::login($user);

        // Redirect after registration
        return redirect()->route('home');
    }

    // Handle user login
    public function login(Request $request)
    {
        // Validate login input
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        // Attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();

            // Redirect based on role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        // If login fails
        return back()->withErrors([
            'failed' => 'Login failed. Please check your email and password.',
        ]);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Handle AJAX-based registration
    public function store(Request $request)
    {
        // Validate request
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        // Create user
        $user = $this->createUser($fields);

        // Return JSON response
        return response()->json($user, 201);
    }


    private function createUser(array $fields): User
    {
        // Create the user with hashed password
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        // Assign role based on email
        if (in_array($user->email, config('admins.emails', ['admin@gmail.com']))) {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }

        return $user;
    }
}