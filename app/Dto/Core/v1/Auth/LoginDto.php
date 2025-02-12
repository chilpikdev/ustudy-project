<?php

namespace App\Dto\Core\v1\Auth;

use App\Http\Requests\Core\v1\Auth\LoginRequest;

readonly class LoginDto
{
    public function __construct(
        public int $phone,
        public string $password,
    ) {}

    public static function from(LoginRequest $request): self
    {
        return new self(
            phone: $request->get('phone'),
            password: $request->get('password')
        );
    }
}
