<?php

namespace App\Dto\Core\v1\Auth;

use App\Http\Requests\Core\v1\Auth\RegistrationRequest;

readonly class RegistrationDto
{
    public function __construct(
        public int $countryId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public int $phone,
        public string $password,
    ) {}

    public static function from(RegistrationRequest $request): self
    {
        return new self(
            countryId: $request->get('country_id'),
            firstName: $request->get('first_name'),
            lastName: $request->get('last_name'),
            email: $request->get('email'),
            phone: $request->get('phone'),
            password: $request->get('password')
        );
    }
}
