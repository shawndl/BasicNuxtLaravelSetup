<?php

namespace App\Observers;

use App\Events\Models\Cache\LocationsChanged;
use App\Location;

class LocationsObserver
{
    /**
     * Listen for when a location is created and deletes the query cache.
     *
     * @param Location $location
     * @return void
     */
    public function created(Location $location)
    {
        event(new LocationsChanged($location));
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @param Location $location
     * @return void
     */
    public function updated(Location $location)
    {
        event(new LocationsChanged($location));
    }

    /**
     * Listen for when a location is deleted and deletes the query cache.
     *
     * @param Location $location
     * @return void
     */
    public function deleted(Location $location)
    {
        event(new LocationsChanged($location));
    }
}