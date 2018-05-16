<?php

namespace App\Providers;

use App\Services\Image\ImageInterventionService;
use App\Services\Image\ImageServiceInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ImageServiceInterface::class, ImageInterventionService::class
        );
    }
}
