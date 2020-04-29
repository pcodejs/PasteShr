<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\SocialProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use Laravel\Socialite\Facades\Socialite;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if(config('settings.registration_open') != 1) return redirect('/')->withErrors(__('Registration is closed'));
        return view('auth.register')->with('page_title',__('Sign up'));
    }    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {        
        $captcha = '';
        if(config('settings.captcha') == 1)
        {
            if(config('settings.captcha_type') == 1) $captcha = 'required|captcha';
            else $captcha = 'required|custom_captcha';
        }
        return Validator::make($data, [
            'name' => ['required', 'alpha_num', 'min:3', 'max:20','unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => $captcha
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user_data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        if(config('settings.auto_approve_user') == 1){
            $user_data['email_verified_at'] = date('Y-m-d H:i:s');
            $user_data['status'] = 1;
        }

        $user = User::create($user_data);

        if(config('settings.auto_approve_user') == 0) $user->sendEmailVerificationNotification();

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if(config('settings.registration_open') != 1) return redirect()->back()->withErrors(__('Registration is closed'));

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if(config('settings.auto_approve_user') == 0){
            return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->withSuccess(__('Your account successfully created').'. '.__('Please check your email box and follow instructions to verify email address'));
        }
        else{
            return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->withSuccess(__('Your account successfully created'));            
        }
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToSocialProvider($provider)
    {
        if(config('settings.registration_open') != 1) return redirect()->back()->withErrors(__('Registration is closed'));

        try {
            if (config('settings.social_login_facebook') == 1) {
                if ($provider == 'facebook') {
                    return Socialite::driver($provider)
                        ->setScopes(['email', 'public_profile'])
                        ->redirect();
                }
            }

            if (config('settings.social_login_twitter') == 1) {
                if ($provider == 'twitter') {
                    return Socialite::driver($provider)->redirect();
                }
            }

            if (config('settings.social_login_google') == 1) {
                if ($provider == 'google') {
                    return Socialite::driver($provider)
                        ->setScopes(['email', 'profile'])
                        ->redirect();
                }
            }

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $exception) {
            return redirect('login')->withErrors($exception->getMessage());
        }
    }  

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $provider
     *
     * @see https://laravel.com/docs/5.7/socialite#retrieving-user-details
     *
     * @return \Illuminate\Http\Response
     */
    public function handleSocialProviderCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->user();
        } catch (\Exception $exception) {
            return redirect('login')->withErrors($exception->getMessage());
        }

        if (!$social_user) {
            return redirect('login')->withErrors(__('Invalid login Try again'));
        }

        if (!$social_user->getEmail()) {
            return redirect('login')->withErrors(__("You must have an email on your social profile"));
        }

        $social_profile = SocialProfile::query()
            ->where([
                ['provider', $provider],
                ['provider_id', $social_user->getId()],
            ])
            ->first();

        if ($social_profile) {
            if (Auth::loginUsingId($social_profile->user_id)) {

                if (Auth::user()->role == 1) {
                    return redirect('admin/dashboard');
                }

                return redirect('/');
            }
        }

        $user = User::query()
            ->whereEmail($social_user->getEmail())
            ->first();

        if ($user) {
            $social_profile = new SocialProfile();
            $social_profile->user_id = $user->id;
            $social_profile->provider = $provider;
            $social_profile->provider_id = $social_user->getId();
            $social_profile->nickname = $social_user->getNickname();
            $social_profile->name = $social_user->getName();
            $social_profile->email = $social_user->getEmail();
            $social_profile->avatar = $social_user->getAvatar();
            $social_profile->save();

            if ($social_profile) {
                if (Auth::loginUsingId($social_profile->user_id)) {

                    if (Auth::user()->role == 1) {
                        return redirect('admin/dashboard');
                    }

                    return redirect('/');
                }
            }
        }

        if(config('settings.registration_open') != 1) return redirect()->back()->withErrors(__('Registration is closed'));

        $user = new User();
        $social_user_email = explode('@', $social_user->getEmail());
        $username = str_limit($social_user_email[0],20);      
        $username = preg_replace("/[^A-Za-z0-9 ]/", '', $username);  
        $user->name = $username;
        $user->email = $social_user->getEmail();
        $user->password = Hash::make(str_random(32));
        $user->role = 2;
        $user->status = 1;
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->avatar = $social_user->getAvatar();

        if ($user->save()) {
            $social_profile = new SocialProfile();
            $social_profile->user_id = $user->id;
            $social_profile->provider = $provider;
            $social_profile->provider_id = $social_user->getId();
            $social_profile->nickname = $social_user->getNickname();
            $social_profile->name = $social_user->getName();
            $social_profile->email = $social_user->getEmail();
            $social_profile->avatar = $social_user->getAvatar();
            $social_profile->save();

            if ($social_profile) {

                if (Auth::loginUsingId($social_profile->user_id)) {
                    if (Auth::user()->role == 1) {
                        return redirect('admin/dashboard')->withSuccess(__('Your account successfully created'));
                    }

                    return redirect('/')->withSuccess(__('Your account successfully created'));
                }
            }
        }
    }

}
