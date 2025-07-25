<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show', 'like', 'comment']),
        ];  
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        //Validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'mimes:webp,png,jpg']
        ]);

        //Store image
        $path = null;
        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        //Create a post
        Auth::user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        //Redirect to dashboard
        return back()->with('success', 'Your post was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post'=> $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('modify', $post);
        return view('posts.edit', ['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //Authorizing the action
        Gate::authorize('modify', $post);

        ///Validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'mimes:webp,png,jpg']

        ]);

        //Store image
        $path = $post->image ?? null;
        if($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        //Update a post
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        //Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //Authorizing the action
        Gate::authorize('modify', $post);

        //Delete post image
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return back()->with('delete', 'Your post was successfully deleted!');
    }

    public function like(Post $post)
    {
        $userId = auth()->id(); // can be null for guests

        // Check if already liked
        $existing = $post->likes()->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete(); // Unlike
        } else {
            $post->likes()->create([
                'user_id' => $userId, // nullable
            ]);
        }

        return back();
    }


    public function comment(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string|max:1000']);

        $post->comments()->create([
            'user_id' => auth()->id(), // Can be null now
            'body' => $request->body,
        ]);

        return back();
    }
}
