<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Http\Resources\UserResource;
use App\Application\Services\UserService;

class UserController extends V1Controller
{
    /**
     * Auth service.
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show user list.
     *
     * @param  Request  $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function index(Request $request)
    {
        $items = $this->userService->getUserList();

        return ApiResponse::success(
            UserResource::collection($items)
        );
    }

    /**
     * Show user detail.
     *
     * @param  Request  $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function show(string|int $id)
    {
        $item = $this->userService->getUserDetail($id);

        return ApiResponse::success(
            new UserResource($item)
        );
    }
}
