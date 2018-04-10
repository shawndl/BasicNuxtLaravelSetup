<?php

namespace App\Http\Middleware\Auth;

use App\Traits\Controllers\JsonResponseTrait;
use App\User;
use Closure;

class UserMustBeActive
{
    use JsonResponseTrait;

    /**
     * @var User
     */
    protected $user;

    /**
     * RedirectIfUserIsNotActive constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->user->email($request->email);
        if(isset($user->id) && $user->hasNotActivated())
        {
            return $this->hasJsonError('Your account is not active', 403);
        }

        return $next($request);
    }
}
