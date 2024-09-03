<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PostController;

Route::group([
    'as'         => 'v1.',
    'prefix'     => 'v1',
], function () {
    /**
     * Routes with guest middleware.
     */
    Route::group(['middleware' => ['guest']], function () {
        /**
         * Auth routes.
         */
        Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
            Route::post('register', [RegisterController::class, 'store'])->name('register');
            Route::post('login', [LoginController::class, 'store'])->name('login');
            Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        });
    });


    /**
     * Routes with auth middleware.
     */
    Route::group(['middleware' => ['auth:sanctum']], function () {
        /**
         * Auth routes.
         */
        Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
            Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        });

        /**
         * User routes.
         */
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
        // Route::get('/user', function (Request $request) {
        //     dd($request);
        //     return $request->user();
        // })->name('user');

        /**
         * Post routes.
         */
        Route::apiResource('posts', PostController::class);
    });
});
