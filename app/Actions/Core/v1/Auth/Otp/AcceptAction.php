<?php

namespace App\Actions\Core\v1\Auth\Otp;

use App\Dto\Core\v1\Auth\OtpAcceptDto;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Cache;
use Illuminate\Http\JsonResponse;

class AcceptAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\Core\v1\Auth\OtpAcceptDto $dto
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(OtpAcceptDto $dto): JsonResponse
    {
        $data = Cache::get('user_' . $dto->phone);

        if (!$data) {
            throw new ApiResponseException(__('auth.user_not_found'), 400);
        }

        if (!Cache::has('otp_verification_' . $dto->phone)) {
            throw new ApiResponseException(__('auth.otp.code_expired'), 400);
        }

        if (Cache::get('otp_verification_' . $dto->phone) != $dto->code) {
            throw new ApiResponseException(__('auth.otp.code_incorrect'), 400);
        }

        $user = User::create($data);

        $user->assignRole('user');

        $user->update(['phone_verified_at' => now()]);

        Cache::forget('user_' . $dto->phone);
        Cache::forget('otp_verification_' . $user->phone);

        return static::toResponse(200, __('auth.otp.account_verifed'));
    }
}
