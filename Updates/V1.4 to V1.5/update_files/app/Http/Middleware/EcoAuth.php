<?php

namespace App\Http\Middleware;

use Closure;

class EcoAuth
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
        } else {
            if (\Auth::user()->status != 1  || empty(\Auth::user()->email_verified_at)) {
                return redirect('/')->withErrors(__('Please check your email box and follow instructions to verify email address to access this page').'. '.__('If you did not receive the email').' <a href="'.route('verification.resend').'">'.__('click here to request another').'</a>');
            }
        }

        return $next($request);
    }
}
