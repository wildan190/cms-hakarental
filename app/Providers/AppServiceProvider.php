<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\BlogRepository;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Repositories\Interface\BlogRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
