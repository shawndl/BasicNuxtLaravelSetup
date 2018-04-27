<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encyclopedia extends Model
{
    protected $fillable = ['path', 'name'];

    /**
     * Get all of the owning encyclopedia models.
     */
    public function moreInfo()
    {
        return $this->morphTo();
    }
}
