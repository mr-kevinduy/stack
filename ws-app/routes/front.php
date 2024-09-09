<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Front\UploadController;

Route::group([
    'prefix'    => front_prefix(),
    'as'        => front_as().'.',
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name(front_home_suffix());

    Route::group([
        'as' => 'uploads.',
        'prefix' => 'uploads',
    ], function () {
        Route::match(['get', 'post'], '/', [UploadController::class, 'index'])->name('index');
    });
});


