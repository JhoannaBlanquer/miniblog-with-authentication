<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $this->createUser($fields);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();

            return Auth::user()->hasRole('admin')
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return back()->withErrors(['failed' => 'Login failed. Please check your email and password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        $user = $this->createUser($fields);

        return response()->json($user, 201);
    }

    private function createUser(array $fields): User
    {
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $user->assignRole(in_array($user->email, config('admins.emails', ['admin@gmail.com'])) ? 'admin' : 'user');

        return $user;
    }

    public function editRole(User $user)
    {
        return view('users.role', compact('user'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|string']);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.dashboard')->with('success', 'Role updated!');
    }

    public function destroy(User $user)
    {
        $user->posts()->delete();
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User and their posts deleted.');
    }
}