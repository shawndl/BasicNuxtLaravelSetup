<?php

namespace App;

use App\Traits\Models\HasFavouriteTrait;
use App\Traits\Models\HasFeedbackTrait;
use App\Traits\Models\HasImageTrait;
use App\Traits\Models\HasNameTrait;
use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Location extends Model
{
    use HasNameTrait, HasUserTrait, HasImageTrait, HasFeedbackTrait, HasFavouriteTrait;

    protected $fillable = ['description', 'latitude', 'longitude', 'user_id', 'image_id', 'location_type_id'];

    public function scopeIsPublic(Builder $builder)
    {
        if(Auth::check())
        {
            return $builder->where('is_private', 0)->orWhere('user_id', Auth::id());
        }
        return $builder->where('is_private', 0);
    }

    /**
     * a location has a type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }
}
