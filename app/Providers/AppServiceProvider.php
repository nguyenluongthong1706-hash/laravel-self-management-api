<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;
use App\Models\Education;
use App\Models\WorkExperience;
use App\Models\ProductLink;
use App\Models\Tool;
use App\Models\Tech;
use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use App\Policies\EducationPolicy;
use App\Policies\WorkExperiencePolicy;
use App\Policies\ProductLinkPolicy;
use App\Policies\ToolPolicy;
use App\Policies\TechPolicy;
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Education::class, EducationPolicy::class);
        Gate::policy(WorkExperience::class, WorkExperiencePolicy::class);
        Gate::policy(ProductLink::class, ProductLinkPolicy::class);
        Gate::policy(Tool::class, ToolPolicy::class);
        Gate::policy(Tech::class, TechPolicy::class);
    }
}
