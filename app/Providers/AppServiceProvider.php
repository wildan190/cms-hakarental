<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\BlogRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Repositories\Interface\BlogRepositoryInterface;
use App\Repositories\Interface\GalleryRepositoryInterface;
use App\Repositories\Interface\MetadataRepositoryInterface;
use App\Repositories\Interface\MobilRepositoryInterface;
use App\Repositories\MetadataRepository;
use App\Repositories\MobilRepository;
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
        $this->app->bind(MobilRepositoryInterface::class, MobilRepository::class);
        $this->app->bind(GalleryRepositoryInterface::class, GalleryRepository::class);
        $this->app->bind(MetadataRepositoryInterface::class, MetadataRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
