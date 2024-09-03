<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Api\V1\V1Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Application\DataTransferObjects\Auth\LoginDto;
use App\Application\Services\AuthService;

class LoginController extends V1Controller
{
    /**
     * Auth service.
     */
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * Authenticate login.
     *
     * @param  LoginRequest  $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function store(LoginRequest $request)
    {
        // Authenticate.
        $credentials = $this->authService->authenticate(LoginDto::fromRequest($request));

        if (! $credentials) {
            return ApiResponse::error(
                message: __('auth.failed'),
                statusCode: 401
            );
        }

        $user = Auth::user();
        if (! $user) {
            return ApiResponse::error();
        }

        return ApiResponse::success([
            'access_token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // return response()->noContent();
        return ApiResponse::success(message: __('auth.logged_out'));
    }
}
