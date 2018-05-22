<?php

namespace App\Events\Models\Cache;

use App\Location;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LocationsChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Location $location
     */
    public function __construct(Location $location)
    {

    }
}
