<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminAccessRequest;
use App\Role;
use App\Traits\Controllers\JsonResponseTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAccessController extends Controller
{
    use JsonResponseTrait;

    public function store(AdminAccessRequest $request, User $user, Role $role)
    {
        try {
            $user = $user->find($request->user_id);
            $role = $role->where('name', 'admin')->first();
            if($request->access)
            {
                $user->roles()->attach($role);
                $message = "$user->name is now an admin";
            } else {
                $user->roles()->detach($role);
                $message = "$user->name is no longer an admin";
            }
        } catch (\Exception $exception) {
            $this->processingError($exception);
        }

        return $this->successResponse($message);
    }
}
