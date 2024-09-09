<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\LoginController;

Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
    /**
     * With guest middleware
     */
    Route::group(['middleware' => ['guest']], function () {
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store'])->name('register');

        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('login');
    });

    /**
     * With auth middleware
     */
    Route::group(['middleware' => ['auth']], function () {
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    });
});
