<?php

namespace App\Http\Middleware\BelongsTo;

use Closure;

class LocationBelongToUser
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
        if(intval($request->route('location')->user_id) !== intval(auth()->id()))
        {
            abort(401);
        }
        return $next($request);
    }
}
