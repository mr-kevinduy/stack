<?php

namespace App\Services\TranscodeService;

use Illuminate\Support\ServiceProvider;

class TranscodeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TranscodeService::class, function ($app) {
            return TranscodeServiceFactory::make(config('services.transcode.default'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
