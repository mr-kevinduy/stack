<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Application\DataTransferObjects\Auth\LoginDto;
use App\Application\Services\AuthService;

class LoginController extends AuthController
{
    protected ?string $resource = 'login';

    /**
     * Auth service.
     */
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return $this->view();
    }

    /**
     * Authenticate login.
     *
     * @param  LoginRequest  $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate.
        $this->authService->authenticate(LoginDto::fromRequest($request));

        // Generate session or token.
        // Use session cookie, you must create route api in web.php (because have middleware session).
        $request->session()->regenerate();

        return redirect()->intended(route(admin_home_route_name(), absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(home_url());
    }
}
