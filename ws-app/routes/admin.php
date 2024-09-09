<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\UserController;

Route::group([
    'prefix'        => admin_prefix(),
    'as'        => admin_as().'.',
], function () {
    Route::get('/', function () {})->name(admin_home_suffix());

    Route::resource('users', UserController::class)->only([
        'index'
    ]);
});
