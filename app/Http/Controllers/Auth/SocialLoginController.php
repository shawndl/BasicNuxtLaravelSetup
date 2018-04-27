<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialLoginController extends Controller
{

    public function redirect(string $service, Request $request)
    {
        return Socialite::driver('github')
            ->stateless()
            ->redirect();
    }

    public function callback(string $service, Request $request)
    {
        $user = Socialite::driver($service)->stateless()->user();

        return response()->json([
            'user' => $user->getName()
        ], 200);

//        return response()->json([
//            'name' => $user->getName()
//        ], 200);

//        // $eloquent user is the user I looked or created in the database
//        $token = JWTAuth::fromUser($eloquentUser)->first());
//
//        // UserResource is an Eloquent API Resources
//        return (new UserResource($request->user()))
//            ->additional([
//                'meta' => [
//                    'token' => $token
//                ]
//            ]);
    }
}
