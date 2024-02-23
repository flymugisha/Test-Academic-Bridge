<?php

namespace App\DataTransferObject;

use App\Http\Requests\LoginRequest;

class UserLoginDto
{
    public function __construct(

        public readonly string $email,
        public readonly string $password,

    ) {
    }

    public static function formUser(LoginRequest $request): UserLoginDto
    {
        return new self(
            $request->validated('email'),
            $request->validated('password'),
        );
    }
}
