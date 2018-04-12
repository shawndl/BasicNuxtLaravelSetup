<?php

namespace App\Http\Controllers\Auth;

use App\Traits\Controllers\JsonResponseTrait;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use JsonResponseTrait;
    /**
     * Logs the User out
     *
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $exception) {
            // dd($exception->getMessage(), $exception->getLine(), $exception->getFile());
            return $this->processingError($exception);
        }

        return response()->json([
            'message' => 'You are logged out!'
        ], 200);
    }
}
