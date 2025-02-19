<?php

namespace App\Http\Controllers\Core\Auth;

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
     * @param \App\Http\Requests\Core\v1\Auth\LoginRequest $request
     * @param \App\Actions\Core\v1\Auth\LoginAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of registration
     * @param \App\Http\Requests\Core\v1\Auth\RegistrationRequest $request
     * @param \App\Actions\Core\v1\Auth\RegistrationAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(RegistrationRequest $request, RegistrationAction $action): JsonResponse
    {
        return $action(RegistrationDto::from($request));
    }

    /**
     * Summary of refreshToken
     * @param \App\Actions\Core\v1\Auth\RefreshTokenAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(RefreshTokenAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of me
     * @param \App\Actions\Core\v1\Auth\GetMeAction $action
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
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => "You're logout",
        ]);
    }
}
