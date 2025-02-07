<?php

namespace App\Actions\Core\v1\Auth;

use App\Actions\Core\v1\Auth\Otp\SendAction;
use App\Dto\Core\v1\Auth\RegistrationDto;
use App\Traits\ResponseTrait;
use Cache;
use Illuminate\Http\JsonResponse;

class RegistrationAction
{
    use ResponseTrait;

    public SendAction $sendAction;

    public function __construct()
    {
        $this->sendAction = new SendAction;
    }

    public function __invoke(RegistrationDto $dto): JsonResponse
    {
        $data = [
            'country_id' => $dto->countryId,
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'password' => $dto->password
        ];

        Cache::put('user_' . $dto->phone, $data, now()->addHour());

        return ($this->sendAction)($data);

        // $user = User::create($data);

        // $user->sendEmailVerificationNotification();

        // return static::toResponse(
        //     message: "Paydalaniwshi jaratildi, ko'rsetilgen email addressin'izdi tastiyiqlaw ushin pochtan'izg'a xat ketti"
        // );
    }
}
