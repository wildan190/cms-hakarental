<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\BlogRepository;
use App\Repositories\FaqRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Repositories\Interface\BlogRepositoryInterface;
use App\Repositories\Interface\FaqRepositoryInterface;
use App\Repositories\Interface\GalleryRepositoryInterface;
use App\Repositories\Interface\MetadataRepositoryInterface;
use App\Repositories\Interface\MobilRepositoryInterface;
use App\Repositories\Interface\TestimoniRepositoryInterface;
use App\Repositories\MetadataRepository;
use App\Repositories\MobilRepository;
use App\Repositories\TestimoniRepository;
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
        $this->app->bind(TestimoniRepositoryInterface::class, TestimoniRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
