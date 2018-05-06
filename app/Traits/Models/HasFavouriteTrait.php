<?php
/**
 * Created by PhpStorm.
 * User: shawnlegge
 * Date: 5/5/18
 * Time: 10:11 AM
 */

namespace App\Traits\Models;


use App\Favourite;
use App\User;

trait HasFavouriteTrait
{
    /**
     * the model can have feedback
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourite');
    }

    /**
     * adds feedback to the model
     *
     * @param User $user
     * @return Model
     */
    public function addFavourite(User $user)
    {
        $favourite = $user->favourites()
            ->where('favourite_id', $this->id)
            ->first();

        if(isset($favourite->id))
        {
            return $favourite->delete();
        }

        return $this->favourites()->create([
            'user_id' => $user->id
        ]);
    }
}