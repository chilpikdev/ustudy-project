<?php

namespace App\Actions\Core\v1\Auth;

use App\Dto\Core\v1\Auth\RegistrationDto;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class RegistrationAction
{
    use ResponseTrait;

    public function __invoke(RegistrationDto $dto): JsonResponse
    {
        $data = [
            'country_id' => $dto->countryId,
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ];

        User::create($data);

        return static::toResponse(
            message: "Paydalaniwshi jaratildi!"
        );
    }
}
