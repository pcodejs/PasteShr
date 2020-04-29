<?php

namespace App\Http\Middleware;

use Closure;

class EcoAdmin
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
        if (!\Auth::check()) {
            if ($request->ajax()) {
                return 'Error - permission denied';
            } else {
                abort(404);
            }
        }

        if ($request->user()->role != 1) {
            if ($request->ajax()) {
                return 'Error - permission denied';
            } else {
                abort(404);
            }

        }

        return $next($request);
    }
}
