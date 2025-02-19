<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Actions\Admin\v1\Auth\GetMeAction;
use App\Actions\Admin\v1\Auth\LoginAction;
use App\Actions\Admin\v1\Auth\RefreshTokenAction;
use App\Dto\Admin\v1\Auth\LoginDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\v1\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Summary of login
     * @param \App\Http\Requests\Admin\v1\Auth\LoginRequest $request
     * @param \App\Actions\Admin\v1\Auth\LoginAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of refreshToken
     * @param \App\Actions\Admin\v1\Auth\RefreshTokenAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of me
     * @param \App\Actions\Admin\v1\Auth\GetMeAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(GetMeAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        auth()->user()->tokens()->where('name', 'refresh token')->delete();

        return response()->json([
            'message' => "You're logout",
        ]);
    }
}
