<?php

namespace App;

use App\Traits\Models\AuthorizationTrait;
use App\Traits\Models\HasConfirmationTrait;
use App\Traits\Models\HasNameTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasConfirmationTrait, HasNameTrait, AuthorizationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * finds User by username
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function scopeName(Builder $builder, string $value)
    {
        return $builder->where('name', $value)->first();
    }

    /**
     * finds User by email
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function scopeEmail(Builder $builder, string $value)
    {
        return $builder->where('email', $value)->first();
    }

    /**
     * a User can have an activation token
     */
    public function token()
    {
        return $this->hasMany(ConfirmationToken::class);
    }
}
