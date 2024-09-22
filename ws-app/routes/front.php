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

        Route::get('/index/{code}', [UploadController::class, 'uploadIndexCreate'])->name('upload-index.create');
        Route::post('/index/{code}', [UploadController::class, 'uploadIndexStore'])->name('upload-index.store');

        Route::get('/video/{code}', [UploadController::class, 'uploadVideoCreate'])->name('upload-video.create');
        Route::post('/video/{code}/store', [UploadController::class, 'uploadVideoStore'])->name('upload-video.store');
        Route::get('/video/{code}/store', [UploadController::class, 'uploadVideoStore'])->name('upload-video.store');
        Route::post('/video/{code}/delete', [UploadController::class, 'uploadVideoDestroy'])->name('upload-video.destroy');

        Route::get('/thumbnail/{code}', [UploadController::class, 'uploadThumbnailCreate'])->name('upload-thumbnail.create');
        Route::post('/thumbnail/{code}', [UploadController::class, 'uploadThumbnailStore'])->name('upload-thumbnail.store');
        Route::post('/thumbnail/{code}/delete', [UploadController::class, 'uploadThumbnailDestroy'])->name('upload-thumbnail.destroy');

        Route::get('/confirm/{code}', [UploadController::class, 'confirm'])->name('confirm');
        Route::post('/store/{code}', [UploadController::class, 'store'])->name('store');
    });
});
