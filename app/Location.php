<?php

namespace App;

use App\Traits\Models\HasNameTrait;
use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasNameTrait, HasUserTrait;

    protected $fillable = ['name', 'description', 'latitude', 'longitude', 'user_id', 'image_id', 'location_type_id'];

    /**
     * a location has an image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * a location has a type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }
}
