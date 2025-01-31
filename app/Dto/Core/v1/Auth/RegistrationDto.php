<?php

namespace App\Dto\Core\v1\Auth;

use App\Http\Requests\Core\v1\Auth\RegistrationRequest;

class RegistrationDto
{
    public function __construct(
        public int $countryId,
        public string $name,
        public string $email,
        public int $phone,
        public string $password,
    ) {}

    public static function from(RegistrationRequest $request): self
    {
        return new self(
            countryId: $request->get('country_id'),
            name: $request->get('name'),
            email: $request->get('email'),
            phone: $request->get('phone'),
            password: $request->get('password')
        );
    }
}
