<?php

namespace App\Listeners\Models\Cache;

use App\Events\Models\Cache\LocationsChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class RemoveLocationCache
{
    /**
     * Handle the event.
     *
     * @param  LocationsChanged  $event
     * @return void
     */
    public function handle(LocationsChanged $event)
    {
        Cache::forget('query.locations.all');
        Cache::forget('query.locations.admin.all');
    }
}
