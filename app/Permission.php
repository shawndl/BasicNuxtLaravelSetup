<?php

namespace App;

use App\Traits\Models\HasRoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Permission extends Model
{
    protected $fillable = ['name'];
    /**
     * a role can have many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

//    public static function boot()
//    {
//        /**
//         * If a permission is created then the cache must be deleted
//         * cache is created in PermissionServiceProvider
//         *
//         * @return void
//         */
//        static::creating(function () {
//            Cache::forget('permissions');
//        });
//    }
}
