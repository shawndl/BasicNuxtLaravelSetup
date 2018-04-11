<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Auth\UserResource;
use App\Traits\Controllers\JsonResponseTrait;
use App\User;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    use JsonResponseTrait;

    /**
     * gets index by pagination
     *
     * @param User $users
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(User $users)
    {

        try {
            $users = $users->paginate(20);
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return UserResource::collection($users);
    }

    /**
     * returns information about a single user
     *
     * @param User $users
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
