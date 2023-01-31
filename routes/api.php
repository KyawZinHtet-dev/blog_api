<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;

// route for register
Route::post('register',[AuthController::class,'register']);

// route for login
Route::post('login',[AuthController::class,'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    
    // route for user profile
    Route::get('/profile',[ProfileController::class,'profile']);

    // route for logout
    Route::post('/logout', [AuthController::class,'logout']);

    // route for category list
    Route::get('/categories', [CategoryController::class, 'index']);

    // route for create post
    Route::post('/post', [PostController::class, 'create']);

    // route for all posts
    Route::get('/post', [PostController::class, 'index']);

    // route for post detail
    Route::get('/post/detail/{id}', [PostController::class, 'showDetail']);

    // route for auth user posts
    Route::get('user/posts', [PostController::class, 'showUserPosts']);
});
