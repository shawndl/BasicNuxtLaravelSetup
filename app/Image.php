<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * get the current instance of a string
     *
     * @param $value
     * @return string
     */
    public function getPathAttribute($value)
    {
        return url(str_replace('public/', 'storage/', $value));
    }
}
