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
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

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
        return $this->roles->contains('name', strtolower($role));
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

    /**
     * does the user have permission to
     *
     * @retun boolean
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    /**
     * is the permission attached to a user 
     * 
     * @param $permission
     * @return bool
     */
    protected function hasPermission($permission)
    {
        return (boolean) $this->permissions->where('name', $permission)->count();
    }
}