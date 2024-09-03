<?php

namespace App\Application\DataTransferObjects\Auth;

use App\Http\Requests\Auth\RegisterRequest;

readonly class RegisterDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    public static function fromRequest(RegisterRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
