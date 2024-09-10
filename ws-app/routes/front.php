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
        Route::get('/', [UploadController::class, 'index'])->name('index');
        Route::post('/upload/{code}', [UploadController::class, 'upload'])->name('upload');
        Route::match(['get', 'post'], '/index/{code}', [UploadController::class, 'uploadIndex'])->name('upload-index');
        Route::match(['get', 'post'], '/video/{code}', [UploadController::class, 'uploadVideo'])->name('upload-video');
        Route::match(['get', 'post'], '/thumbnail/{code}', [UploadController::class, 'uploadThumbnail'])->name('upload-thumbnail');
    });
});


