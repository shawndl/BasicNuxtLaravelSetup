<?php

namespace App\Http\Controllers\Auth;

use App\ConfirmationToken;
use App\Traits\Controllers\JsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivationController extends Controller
{
    use JsonResponseTrait;

    /**
     * activate the User account if the token matches the User
     *
     * @param ConfirmationToken $token
     * @return mixed
     */
    public function activate(ConfirmationToken $token)
    {
        try {
            $user = $token->user;
            $user->is_active = true;
            $user->save();
            //$token->delete();
        } catch (\Exception $exception) {
            if($exception->getMessage() !== 'Creating default object from empty value')
            {
                $this->processingError($exception);
            }
        }

        return $this->successResponse('Congratulations, your account has been activated!', 200);
    }
}
