<?php

namespace App;

use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasUserTrait;

    protected $fillable = [
        'user_id', 'comment', 'review'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function location()
    {
        return $this->morphTo();
    }
}
