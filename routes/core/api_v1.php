<?php

use App\Enums\TokenAbilityEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('auth')->middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value])->group(function () {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

Route::prefix('auth')->middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ACCESS_TOKEN->value])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('test', function () {
        return response()->json([
            'message' => 'authenticated'
        ]);
    });
});

Route::get('posts', [PostController::class, 'posts']);
