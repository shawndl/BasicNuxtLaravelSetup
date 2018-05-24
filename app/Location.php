<?php

namespace App;

use App\Traits\Models\HasFavouriteTrait;
use App\Traits\Models\HasFeedbackTrait;
use App\Traits\Models\HasImageTrait;
use App\Traits\Models\HasNameTrait;
use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Location extends Model
{
    use HasNameTrait, HasUserTrait, HasImageTrait, HasFeedbackTrait, HasFavouriteTrait;

    protected $fillable = ['description', 'latitude', 'longitude', 'user_id', 'image_id', 'location_type_id'];

    /**
     * returns only if the location is private or belongs to the user
     *
     * @param Builder $builder
     * @return $this|Builder|static
     */
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

    /**
     * adds a location to the database
     *
     * @param Request $request
     * @param Image | boolean $image
     * @return mixed
     */
    public function add(Request $request, $image)
    {
        $id = ($image instanceof Image) ? $image->id : null;
        return $this
            ->create($this->getArrayFromRequest($request, $id));
    }

    /**
     * updates a location
     * @param Image | false $image
     * @param Request $request
     * @return bool
     */
    public function edit(Request $request, $image)
    {
        $id = ($image instanceof Image) ? $image->id : $this->image_id;
        return $this
            ->update($this->getArrayFromRequest($request, $id));
    }

    /**
     * prepares an array for the database
     *
     * @param Request $request
     * @param int | null $id
     * @return array
     */
    private function getArrayFromRequest(Request $request, $id)
    {
        return [
            'user_id' => Auth::id(),
            'image_id' => $id,
            'location_type_id' => $request->type,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_private'=> $request->private
        ];
    }
}
