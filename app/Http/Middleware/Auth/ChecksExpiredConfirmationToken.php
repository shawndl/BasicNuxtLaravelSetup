<?php

namespace App\Http\Middleware\Auth;

use App\ConfirmationToken;
use App\Traits\Controllers\JsonResponseTrait;
use Closure;

class ChecksExpiredConfirmationToken
{
    use JsonResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->route()->parameters()['confirmation_token'];
        if(!isset($token) && !($token instanceof ConfirmationToken))
        {
            return $this->hasJsonError('No token was provided', 422);
        }

        if($token->hasExpired())
        {
            return $this->hasJsonError('Your confirmation token is expired, please request another one!', 422);
        }
        return $next($request);
    }
}
