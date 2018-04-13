<?php

namespace App;

use App\Traits\Models\HasNameTrait;
use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    use HasNameTrait;

    protected $fillable = [
        'name', 'description', 'season_start', 'season_finish'
    ];

    protected $dates = [
        'season_start', 'season_finish'
    ];

    /**
     * a type can have many locations
     */
    public function locations()
    {
        $this->hasMany(Location::class);
    }
}
