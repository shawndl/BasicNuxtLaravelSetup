<?php

namespace App;

use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasUserTrait;

    protected $fillable = [
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function location()
    {
        return $this->morphTo();
    }
}
