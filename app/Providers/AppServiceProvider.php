<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Image\UploadImageService;
use App\Services\Image\UploadImageCloudinaryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UploadImageService::class,
            UploadImageCloudinaryService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
