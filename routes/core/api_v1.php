<?php

use App\Enums\TokenAbilityEnum;
use App\Http\Controllers\Core\Auth\AuthController;
use App\Http\Controllers\Core\Auth\EmailVerificationController;
use App\Http\Controllers\Core\Auth\OtpVerificationController;
use App\Http\Controllers\Core\CommentController;
use App\Http\Controllers\Core\PostController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
Route::pattern('base', '[a-zA-Z0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('username', '[a-z0-9_-]{3,16}');

/**
 * Public
 */
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'posts']);
    Route::get('show/{id}', [PostController::class, 'show']);
    Route::get('/recommended', [PostController::class, 'recommended']);

    Route::post('share', [PostController::class, 'share']);
});

/**
 * Guest
 */
Route::prefix('auth')->middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('otp/accept', [OtpVerificationController::class, 'accept']);
    Route::get('email/verify/{id}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});

/**
 * Auth for Refresh Token
 */
Route::prefix('auth')->middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value])->group(function () {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

/**
 * Routs for Auth
 */
Route::middleware(['auth:sanctum', 'ability:' . TokenAbilityEnum::ACCESS_TOKEN->value])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
    });

    /**
     * Routs for Auth & Verified Users
     */
    Route::middleware(['verified_phone'])->group(function () {
        Route::prefix('comment')->group(function () {
            Route::post('create', [CommentController::class, 'create']);
            Route::put('update', [CommentController::class, 'update']);
            Route::delete('delete/{id}', [CommentController::class, 'delete']);
        });
    });


});

