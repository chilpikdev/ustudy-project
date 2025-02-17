<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Core\v1\Auth\GetMeAction;
use App\Actions\Core\v1\Auth\LoginAction;
use App\Actions\Core\v1\Auth\RefreshTokenAction;
use App\Actions\Core\v1\Auth\RegistrationAction;
use App\Dto\Core\v1\Auth\LoginDto;
use App\Dto\Core\v1\Auth\RegistrationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\v1\Auth\LoginRequest;
use App\Http\Requests\Core\v1\Auth\RegistrationRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Summary of login
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of registration
     */
    public function registration(RegistrationRequest $request, RegistrationAction $action): JsonResponse
    {
        return $action(RegistrationDto::from($request));
    }

    /**
     * Summary of refreshToken
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of me
     */
    public function me(GetMeAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of logout
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => "You're logout",
        ]);
    }
}
