<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Application\DataTransferObjects\Auth\RegisterDto;
use App\Application\Services\AuthService;

class RegisterController extends AuthController
{
    protected ?string $resource = 'register';

    /**
     * Auth service.
     */
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return $this->view();
    }

    /**
     * Register new account.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $this->authService->register(RegisterDto::fromRequest($request));

        return redirect(route(admin_home_route_name(), absolute: false));
    }
}
