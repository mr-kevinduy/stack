<?php

namespace App\Application\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Application\DataTransferObjects\Auth\RegisterDto;
use App\Application\DataTransferObjects\Auth\LoginDto;
use App\Application\Contracts\Repositories\UserRepository;

class AuthService extends AbstractService
{
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * Create new user.
     *
     * @param  RegisterDto $dto
     * @return User
     */
    public function register(RegisterDto $dto)
    {
        $user = $this->repository->save([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return $user;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(LoginDto $dto)
    {
        $this->ensureIsNotRateLimited($dto);

        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];

        if (! Auth::attempt($credentials, $dto->remember)) {
            RateLimiter::hit($this->throttleKey($dto));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($dto));

        return $credentials;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(LoginDto $dto): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($dto), 5)) {
            return;
        }

        event(new Lockout($dto));

        $seconds = RateLimiter::availableIn($this->throttleKey($dto));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(LoginDto $dto): string
    {
        return Str::transliterate(Str::lower($dto->email).'|'.$dto->ip);
    }
}
