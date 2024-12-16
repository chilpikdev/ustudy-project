<?php

namespace App\Actions\Core\v1\Auth;

use App\Dto\Core\v1\Auth\LoginDto;
use App\Enums\TokenAbilityEnum;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __invoke(LoginDto $dto): JsonResponse
    {
        try {
            $user = User::where('email', $dto->email)->firstOrFail();

            if (!Hash::check($dto->password, $user->password)) {
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
}
