<?php

namespace App;

use App\Traits\Models\HasNameTrait;
use App\Traits\Models\HasPermissionTrait;
use App\Traits\Models\HasUserTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasUserTrait, HasNameTrait;

    protected $fillable = ['name'];

}
