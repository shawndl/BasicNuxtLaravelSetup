<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    /**
     * adds an image to the database
     *
     * @param Request $request
     * @return bool | Image
     */
    public function add(Request $request)
    {
        if(!$request->has('image')) return false;

        $path = $request->file('image')->store('public');
        return $this->create([
            'path' => $path
        ]);
    }
}
