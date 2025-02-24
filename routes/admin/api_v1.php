<?php

use App\Enums\TokenAbilityEnum;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
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

/**
 * Guest
 */
Route::prefix('auth')->middleware('guest:sanctum')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
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
    });

    /**
     * Routs for Auth & Verified Users
     */
    Route::middleware(['verified_phone', 'role:admin|moderator'])->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::post('create', [PostController::class, 'create']);
            Route::get('show/{id}', [PostController::class, 'show']);
            Route::put('update', [PostController::class, 'show']);
            Route::delete('delete/{id}', [PostController::class, 'show']);
        });
    });
});

// TODO: file birme-bir o'shiriw
// TODO: crud lardin' basqalarinda logikasin jaziw
// TODO: file di response penen qaytariw
// TODO: Collections & Resurses
