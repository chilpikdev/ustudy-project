<?php

namespace App\Actions\Core\v1\Auth;

use App\Dto\Core\v1\Auth\LoginDto;
use App\Enums\TokenAbilityEnum;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    use ResponseTrait;

    public function __invoke(LoginDto $dto): JsonResponse
    {
        try {
            $user = User::where('phone', $dto->phone)->firstOrFail();

            if (! Hash::check($dto->password, $user->password)) {
                throw new ApiResponseException('Kiritilgen parol duris emes', 401);
            }

            auth()->login($user);

            $accessTokenExpiration = now()->addMinutes(config('sanctum.at_expiration'));
            $refreshTokenExpiration = now()->addMinutes(config('sanctum.rt_expiration'));

            $accessToken = auth()->user()->createToken(
                name: 'access token',
                abilities: [TokenAbilityEnum::ACCESS_TOKEN->value],
                expiresAt: $accessTokenExpiration
            );

            $refreshToken = auth()->user()->createToken(
                name: 'refresh token',
                abilities: [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value],
                expiresAt: $refreshTokenExpiration
            );

            return static::toResponse(
                data: [
                    'access_token' => $accessToken->plainTextToken,
                    'refresh_token' => $refreshToken->plainTextToken,
                    'at_expired_at' => $accessTokenExpiration->format('Y-m-d H:i:s'),
                    'rf_expired_at' => $refreshTokenExpiration->format('Y-m-d H:i:s'),
                ]
            );
        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException('paydalaniwshi tabilmadi');
        }
    }
}
