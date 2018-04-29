<?php

namespace App\Http\Middleware\Maps;

use Closure;

class FeedBackMustBelongToUser
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
        if(intval($request->route('feedback')->user_id) !== intval(auth()->id()))
        {
            abort(401);
        }
        return $next($request);
    }
}
