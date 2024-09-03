<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Api\V1\V1Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Resources\UserResource;
use App\Application\DataTransferObjects\Auth\RegisterDto;
use App\Application\Services\AuthService;

class RegisterController extends V1Controller
{
    /**
     * Auth service.
     */
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * Register new account.
     *
     * @param  RegisterRequest  $request
     * @return App\Http\Responses\ApiResponse
     */
    public function store(RegisterRequest $request)
    {
        $user = $this->authService->register(RegisterDto::fromRequest($request));

        return ApiResponse::success(
            new UserResource($user)
        );
    }
}
