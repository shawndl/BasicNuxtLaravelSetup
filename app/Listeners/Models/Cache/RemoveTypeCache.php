<?php

namespace App\Listeners\Models\Cache;

use App\Events\Models\Cache\TypeChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class RemoveTypeCache
{
    /**
     * Handle the event.
     *
     * @param  TypeChanged  $event
     * @return void
     */
    public function handle(TypeChanged $event)
    {
        Cache::forget('query.types.all');
    }
}
