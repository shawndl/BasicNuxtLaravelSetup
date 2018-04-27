<?php

namespace App;

use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasUserTrait;

    /**
     * feedback has a location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
