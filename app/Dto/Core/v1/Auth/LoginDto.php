<?php

namespace App\Dto\Core\v1\Auth;

use App\Http\Requests\Core\v1\Auth\LoginRequest;

class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function from(LoginRequest $request): self
    {
        return new self(
            email: $request->get('email'),
            password: $request->get('password')
        );
    }
}
