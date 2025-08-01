<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $posts = Post::all();

        return view('admin.admin', [
            'users' => $users,
            'posts' => $posts,
            'userCount' => $users->count(),
            'postCount' => $posts->count(),
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