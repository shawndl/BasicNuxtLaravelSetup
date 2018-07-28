<?php

namespace App\Providers;

use App\Feedback;
use App\Location;
use App\LocationType;
use App\Observers\FeedbackObserver;
use App\Observers\LocationsObserver;
use App\Observers\TypeObserver;
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

        Location::observe(LocationsObserver::class);
        LocationType::observe(TypeObserver::class);
        Feedback::observe(FeedbackObserver::class);
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
