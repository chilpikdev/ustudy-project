<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Core\v1\Auth\GetMeAction;
use App\Actions\Core\v1\Auth\LoginAction;
use App\Actions\Core\v1\Auth\RegistrationAction;
use App\Dto\Core\v1\Auth\LoginDto;
use App\Dto\Core\v1\Auth\RegistrationDto;
use App\Enums\TokenAbilityEnum;
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action(LoginDto::from($request));
    }

    /**
     * Summary of registration
     * @param \App\Http\Requests\Core\v1\Auth\RegistrationRequest $request
     * @param \App\Actions\Core\v1\Auth\RegistrationAction $action
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function registration(RegistrationRequest $request, RegistrationAction $action): JsonResponse
    {
        return $action(RegistrationDto::from($request));
    }

    /**
     * Summary of refreshToken
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $accessTokenExpiration = now()->addMinutes(config('sanctum.at_expiration'));

        $accessToken =  auth()->user()->createToken(
            name: 'access token',
            abilities: [TokenAbilityEnum::ACCESS_TOKEN->value],
            expiresAt: $accessTokenExpiration
        );

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
            'at_expired_at' => $accessTokenExpiration->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Summary of me
     * @param \App\Actions\Core\v1\Auth\GetMeAction $action
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function me(GetMeAction $action): JsonResponse
    {
        return $action();
    }

    /**
     * Summary of logout
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "You're logout"
        ]);
    }
}
