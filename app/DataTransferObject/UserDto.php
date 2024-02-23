<?php

namespace App\DataTransferObject;

use App\Http\Requests\UserRequest;

class UserDto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $phone,
    ) {
    }

    public static function formUser(UserRequest $request): UserDto
    {
        return new self(
            $request->validated('firstName'),
            $request->validated('lastName'),
            $request->validated('email'),
            $request->validated('password'),
            $request->validated('phone'),
        );
    }
}
