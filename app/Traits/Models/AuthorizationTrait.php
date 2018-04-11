<?php

namespace App\Traits\Models;


use App\Permission;
use App\Role;

trait AuthorizationTrait
{
    /**
     * has many to many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * does the user have a specific role or roles
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole(string $role)
    {
        return $this->roles->contains('name', ucwords($role));
    }

    /**
     * checks is the user has any role in an array
     *
     * @param array ...$roles
     * @return bool
     */
    public function hasAnyRole(...$roles)
    {
        foreach ($roles as $role)
        {
            if($this->hasRole($role))
            {
                return true;
            }
        }
        return false;
    }
}