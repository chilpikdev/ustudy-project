<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TokenAbilityEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();

            if (!Hash::check($request->password, $user->password)) {
                throw new AuthenticationException();
            }

            auth()->login($user);

            $accessTokenExpiration = now()->addMinutes(config('sanctum.ac_expiration'));
            $refreshTokenExpiration = now()->addMinutes(config('sanctum.rt_expiration'));

            $accessToken =  auth()->user()->createToken(
                name: 'access token',
                abilities: [TokenAbilityEnum::ACCESS_TOKEN->value],
                expiresAt: $accessTokenExpiration
            );

            $refreshToken =  auth()->user()->createToken(
                name: 'refresh token',
                abilities: [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value],
                expiresAt: $refreshTokenExpiration
            );

            return response()->json([
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
                'at_expired_at' => $accessTokenExpiration->format('Y-m-d H:i:s'),
                'rf_expired_at' => $refreshTokenExpiration->format('Y-m-d H:i:s'),
            ]);
        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException("paydalaniwshi tabilmadi");
        }
    }

    /**
     * Summary of refreshToken
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $accessTokenExpiration = now()->addMinutes(config('sanctum.ac_expiration'));

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
