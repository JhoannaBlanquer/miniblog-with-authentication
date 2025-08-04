<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Basic ping check
Route::middleware('api')->get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// Admin posts API (protected)
Route::middleware('auth:sanctum')->get('/admin/posts', [PostController::class, 'allPostsApi']);
