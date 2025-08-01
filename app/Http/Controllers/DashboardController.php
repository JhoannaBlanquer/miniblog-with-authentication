<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(User $user)
    {
        $userPosts = $user->posts()->latest()->get();
        return view('users.posts', [
            'posts' => $userPosts,
            'user' => $user,
        ]);
    }

    public function admin()
    {
        $posts = Post::oldest()->get();
        $userCount = User::count(); 
        $postCount = $posts->count(); 

        return view('admin.admin', [
            'posts' => $posts,
            'userCount' => $userCount,
            'postCount' => $postCount,
        ]);
    }
}