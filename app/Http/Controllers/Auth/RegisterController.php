<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\UserSignedUp;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Traits\Controllers\JsonResponseTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use JsonResponseTrait;

    public function register(RegisterUserRequest $request, User $user)
    {
        try {
            $user = $user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            event(new UserSignedUp($user));
        } catch (\Exception $exception) {
            dd($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return $this->processingError($exception);
        }


        return response()->json([
            'message' => 'Your registration is successful, please check your email to activate your account!'
        ], 201);
    }
}
