<?php

namespace App;

use App\Traits\Models\HasUser;
use Illuminate\Database\Eloquent\Model;

class ConfirmationToken extends Model
{
    use HasUser;

    public $timestamps = false;

    protected $dates = [
        'expires_at'
    ];

    protected $fillable = [
        'token', 'expires_at'
    ];

    /**
     * routes will find this record by token
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    public static function boot()
    {
        /**
         * deletes previous token if one exists for the User
         *
         * @return void
         */
        static::creating(function ($token) {
            optional($token->user->confirmationToken)->delete();
        });
    }

    /**
     * has the token expired
     *
     * @return bool
     */
    public function hasExpired()
    {
        return $this->freshTimestamp()->gt($this->expires_at);
    }
}
