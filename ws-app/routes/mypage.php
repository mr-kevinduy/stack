<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MyPage\VideoController;
use App\Http\Controllers\Web\MyPage\VideoUploadController;

Route::group([
    'prefix'    => 'mypage',
    'as'        => 'mypage.',
], function () {
    Route::get('/', function () {
        return redirect('/mypage/videos');
    })->name('mypage.home.index');

    Route::group([
        'as' => 'videos.',
        'prefix' => 'videos',
    ], function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');

        Route::group([
            'as' => 'uploads.',
            'prefix' => 'uploads',
        ], function () {
            Route::get('/', [VideoUploadController::class, 'index'])->name('index');

            Route::get('/index/{code}', [VideoUploadController::class, 'indexCreate'])->name('index.create');
            Route::post('/index/{code}', [VideoUploadController::class, 'indexStore'])->name('index.store');

            Route::get('/video/{code}', [VideoUploadController::class, 'videoCreate'])->name('video.create');
            Route::post('/video/{code}', [VideoUploadController::class, 'videoStore'])->name('video.store');
            Route::post('/video/{code}/delete', [VideoUploadController::class, 'videoDestroy'])->name('video.destroy');

            Route::get('/thumbnail/{code}', [VideoUploadController::class, 'thumbnailCreate'])->name('thumbnail.create');
            Route::post('/thumbnail/{code}', [VideoUploadController::class, 'thumbnailStore'])->name('thumbnail.store');
            Route::post('/thumbnail/{code}/delete', [VideoUploadController::class, 'thumbnailDestroy'])->name('thumbnail.destroy');

            Route::get('/confirm/{code}', [VideoUploadController::class, 'confirm'])->name('confirm');
            Route::post('/store/{code}', [VideoUploadController::class, 'store'])->name('store');
        });
    });
});


