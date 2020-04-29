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
        if(config('settings.maintenance_mode') == 1 && $request->segment(1) != 'admin'){
            echo view('front.page.maintenance')->with('page_title', __('Site Under Maintenance'));
            exit;
        }
        
        if (!\Auth::check()) {
            if ($request->ajax()) {
                return 'Error - permission denied';
            } else {
                abort(404);
            }
        } else {
            if(\Auth::user()->status == 2){ 
                \Auth::logout();
                return redirect('/')->withErrors(__('Your account is banned'));
            }            
            elseif (\Auth::user()->status != 1  || empty(\Auth::user()->email_verified_at)) {
                return redirect('/')->withErrors(__('Please check your email box and follow instructions to verify email address to access this page').'. '.__('If you did not receive the email').' <a href="'.route('verification.resend').'">'.__('click here to request another').'</a>');
            }
            else{
                if(config('settings.captcha_for_verified_users') == 0) config(['settings.captcha'=>0]);
            }
        }

        return $next($request);
    }
}
