<?php

namespace App\Http\Controllers\Auth;

use App\ConfirmationToken;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    use JsonResponseTrait;

    /**
     * activate the User account if the token matches the User
     *
     * @param ConfirmationToken $token
     * @param Request $request
     * @return mixed
     */
    public function activate(ConfirmationToken $token, Request $request)
    {
        try {
            $user = $token->user;
            $user->is_active = true;
            $user->save();
            $token->delete();
        } catch (\Exception $exception) {
            return $this->processingError($exception);
        }

        return response()->json([
            'message' => 'Congratulations, your account has been activated!'
        ], 200);
    }
}
