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
     * a location has a type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationType()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
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
