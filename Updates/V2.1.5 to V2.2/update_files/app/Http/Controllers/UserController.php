<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{

    public function profile($username)
    {
        $user   = User::where('name', $username)->firstOrfail();
        $pastes = Paste::where('user_id', $user->id)->where('status', 1)->where(function($query){
            $query->orWhereNull('user_id');
            $query->orWhereHas('user',function($user){
                $user->whereIn('status',[0,1]);
            });
        })->limit(20)->get(['title', 'syntax', 'slug', 'created_at', 'password', 'expire_time', 'views']);
        return view('front.user.show', compact('user', 'pastes'))->with('page_title', $user->name);
    }

    public function contact($name, Request $request)
    {
        $captcha = '';
        if (config('settings.captcha') == 1) {
            if (config('settings.captcha_type') == 1) {
                $captcha = 'required|captcha';
            } else {
                $captcha = 'required|custom_captcha';
            }

        }
        $validator = Validator::make($request->all(), [
            'name'                 => 'required|eco_alpha_spaces|min:2|max:100',
            'email'                => 'required|email|max:100',
            'message'              => 'required|string|min:10|max:5000',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = User::where('name', $name)->firstOrfail(['name', 'email']);
            try {
                \Mail::send('emails.user', ['request' => $request, 'user' => $user], function ($m) use ($user) {
                    $m->to($user->email)->subject(config('settings.site_name') . ' - ' . __('Contact Message'));
                });
            } catch (\Exception $e) {
                \Log::info($e->getMessage());
                return redirect()->back()->with('warning', __('Your message was not sent due to invalid mail configuration'));
            }

            return redirect()->back()->with('success', __('Your message successfully sent'));
        }

    }

    public function edit()
    {
        $user = User::findOrfail(\Auth::user()->id);
        return view('front.user.edit', compact('user'))->with('page_title', __('Edit Profile'));
    }

    public function update(Request $request)
    {              
        $user      = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password'              => 'nullable|min:6|string|confirmed',
            'password_confirmation' => 'sometimes',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
            'about'                 => 'nullable|eco_long_string|max:500',
            'fb'                    => 'nullable|url|max:255',
            'tw'                    => 'nullable|url|max:255',
            'gp'                    => 'nullable|url|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!empty($request->password)) {
            $user->password = \Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $destinationPath = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if (!empty($user->avatar)) {
                @unlink(ltrim($user->avatar, '/'));
            }
            $random              = str_random(10);
            $avatar              = $request->file('avatar');
            $file_ext            = $avatar->getClientOriginalExtension();
            $avatar_name         = $random . '.' . $file_ext;
            $resized_avatar_name = $random . '_120x120.' . $file_ext;

            $avatar->move($destinationPath, $avatar_name);
            $original_avatar = $destinationPath . '/' . $avatar_name;

            Image::make($original_avatar)->resize(120, 120)->save($destinationPath . '/' . $resized_avatar_name);

            $user->avatar = '/' . $destinationPath . '/' . $resized_avatar_name;
            @unlink($original_avatar);
        }

        $user->about = $request->about;
        $user->fb    = $request->fb;
        $user->tw    = $request->tw;
        $user->gp    = $request->gp;

        $user->save();
        return redirect()->back()->withSuccess(__('Profile successfully updated'));
    }

    public function destroy(Request $request)
    {
        $captcha = '';
        if (config('settings.captcha_type') == 1) {
            $captcha = 'required|captcha';
        } else {
            $captcha = 'required|custom_captcha';
        }

        $user      = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password'              => 'required|min:6|string',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if(\Hash::check($request->password,$user->password)) {
            \Auth::logout();
            if($user->delete()) return redirect('/')->withSuccess(__('Your account has been deleted successfully'));
        }
        else{
            return redirect()->back()->withErrors(__('Please enter valid password'));
        }
    }
}
