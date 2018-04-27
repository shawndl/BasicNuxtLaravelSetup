<?php

namespace App;

use App\Traits\Models\HasImageTrait;
use App\Traits\Models\HasNameTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationType extends Model
{
    use HasNameTrait, HasImageTrait, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'season_start', 'season_finish', 'image_id', 'icon'
    ];

    protected $dates = [
        'season_start', 'season_finish', 'deleted_at'
    ];

    /**
     * an type has an image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * a type can have many locations
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function encyclopedia()
    {
        return $this->morphMany(Encyclopedia::class, 'encyclopedia');
    }

    /**
     * adds an encyclopedia to the model
     *
     * @param string $link
     * @return Model
     */
    public function addLink(string $link, string $name)
    {
        return $this->encyclopedia()->create([
            'path' => $link,
            'name' => $name
        ]);
    }

    /**
     * does this row have a link to a specific encyclopedia
     *
     * @param Encyclopedia $encyclopedia
     */
    public function hasLinkTo(Encyclopedia $encyclopedia)
    {
        return $this->encyclopedia->contains($encyclopedia);
    }
}
