<?php

namespace App\Http\Middleware\Auth;

use Closure;

class ChecksExpiredConfirmationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->confirmation_token->hasExpired())
        {
            return response()->json([
                'error' => 'Your confirmation token is expired, please request another one!'
            ], 422);
        }
        return $next($request);
    }
}
