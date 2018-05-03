<?php

namespace App;

use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    use HasUserTrait;

    protected $table = 'user_socials';

    protected $fillable = ['social_id', 'service'];
}
