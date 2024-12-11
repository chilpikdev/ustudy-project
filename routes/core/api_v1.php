<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', function () {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "You're logout"
        ]);
    });
    Route::get('test2', function () {
        return response()->json([
            'message' => 'authenticated!'
        ]);
    });
});


Route::get('posts', [PostController::class, 'posts']);
