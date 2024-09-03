<?php

namespace App\Application\DataTransferObjects\Auth;

use App\Http\Requests\Auth\LoginRequest;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
        public ?bool $remember = null,
        public ?string $ip = null
    ) {}

    public static function fromRequest(LoginRequest $request)
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
            remember: $request->boolean('remember'),
            ip: $request->ip()
        );
    }
}
