<?php

namespace App\Application;

use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        'User',
        'Post',
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepository($this->repositories);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepository(array $repositories = [])
    {
        foreach ($repositories as $key => $repository) {
            $this->app->singleton(
                'App\Application\Contracts\Repositories\\'.ucfirst($repository).'Repository',
                'App\Application\Repositories\Eloquent\\'.ucfirst($repository).'RepositoryEloquent'
            );
        }
    }
}
