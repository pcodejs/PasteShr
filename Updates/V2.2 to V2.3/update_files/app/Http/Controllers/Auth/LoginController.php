<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login')->with('page_title',__('Login'));
    }




    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $captcha = '';
        if(config('settings.captcha') == 1)
        {
            if(config('settings.captcha_type') == 1) $captcha = 'required|captcha';
            else $captcha = 'required|custom_captcha';
        }

        if(strpos($request->email, '@'))
        {
	        $request->validate([
	            $this->username() => 'required|max:150|email',
	            'password' => 'required|string|max:20',
	            'g-recaptcha-response' => $captcha
	        ]);
	    }
	    else{
	    	$request->validate([
	            $this->username() => 'required|alpha_num|max:100',
	            'password' => 'required|string|max:20',
	            'g-recaptcha-response' => $captcha
	        ]);
	    }
    }    

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $this->validateLogin($request);
        // $credentials = $request->only('username', 'password');
        $remember = false;
        if ($request->remember == 'on') {
            $remember = true;
        }

        if (\Auth::attempt(["name" => $request->email, "password" => $request->password], $remember)) {
            if(\Auth::user()->status == 2){ 
                \Auth::logout();
                return redirect()->back()->withErrors(__('Your account is banned'));
            }
            // Authentication passed...
            return redirect()->intended()->withSuccess(__('You succesfully logged in'));
        } elseif (\Auth::attempt(["email" => $request->email, "password" => $request->password], $remember)) {
            if(\Auth::user()->status == 2){ 
                \Auth::logout();
                return redirect()->back()->withErrors(__('Your account is banned'));
            }
            // Authentication passed...
            return redirect()->intended()->withSuccess(__('You succesfully logged in'));
        } else {
            return redirect()->back()->withErrors(__('Invalid Username or Password'));
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }
}
