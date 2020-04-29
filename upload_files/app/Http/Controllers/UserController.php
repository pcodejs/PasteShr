<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('front.user.index')->with('page_title', __('Dashboard'));
    }

    public function pastes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'sometimes|min:2|max:100|eco_string',
        ]);
        if ($validator->fails()) {
            return redirect(route('user.pastes'))
                ->withErrors($validator);
        }

        $pastes = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC');

        if (!empty($request->keyword)) {
            $search_term = $request->keyword;
            $pastes = $pastes->where(function ($q) use ($search_term) {
                $q->orWhere('title', 'like', '%' . $search_term . '%');
                $q->orWhere('content', 'like', '%' . $search_term . '%');
                $q->orWhere('syntax', 'like', '%' . $search_term . '%');

            });
        }

        $pastes = $pastes->paginate(config('settings.pastes_per_page'));

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->where(function ($query) {
            $query->where('expire_time', '>', \Carbon\Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at', 'password', 'expire_time', 'views']);
        return view('front.user.pastes', compact('pastes', 'recent_pastes'))->with('page_title', __('My Pastes'));
    }

    public function profile($username)
    {
        $user = User::where('name', $username)->firstOrfail();
        $pastes = Paste::where('user_id', $user->id)->where('status', 1)->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
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
            'name' => 'required|eco_alpha_spaces|min:2|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|min:10|max:5000',
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
        $user = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password' => 'nullable|min:6|string|confirmed',
            'password_confirmation' => 'sometimes',
            'avatar' => 'sometimes|mimes:jpeg,jpg,png|max:1024',
            'about' => 'nullable|eco_long_string|max:500',
            'fb' => 'nullable|url|max:255',
            'tw' => 'nullable|url|max:255',
            'gp' => 'nullable|url|max:255',
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
            $random = str_random(10);
            $avatar = $request->file('avatar');
            $file_ext = $avatar->getClientOriginalExtension();
            $avatar_name = $random . '.' . $file_ext;
            $resized_avatar_name = $random . '_120x120.' . $file_ext;

            $avatar->move($destinationPath, $avatar_name);
            $original_avatar = $destinationPath . '/' . $avatar_name;

            Image::make($original_avatar)->resize(120, 120)->save($destinationPath . '/' . $resized_avatar_name);

            $user->avatar = '/' . $destinationPath . '/' . $resized_avatar_name;
            @unlink($original_avatar);
        }

        $user->about = $request->about;
        $user->fb = $request->fb;
        $user->tw = $request->tw;
        $user->gp = $request->gp;

        $user->save();
        return redirect()->back()->withSuccess(__('Profile successfully updated'));
    }

    public function destroyShow()
    {
        $user = User::findOrfail(\Auth::user()->id);
        return view('front.user.destroy', compact('user'))->with('page_title', __('Delete Account'));
    }

    public function destroy(Request $request)
    {
        $captcha = 'required|custom_captcha';

        $user = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|string',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (\Hash::check($request->password, $user->password)) {
            \Auth::logout();
            if ($user->delete()) return redirect('/')->withSuccess(__('Your account has been deleted successfully'));
        } else {
            return redirect()->back()->withErrors(__('Please enter valid password'));
        }
    }

    public function backupShow()
    {
        return view('front.user.backup')->with('page_title', __('Backup Pastes'));
    }

    public function backup(Request $request)
    {
        $captcha = 'required|custom_captcha';

        $user = User::findOrfail(\Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|string',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (\Hash::check($request->password, $user->password)) {

            $pastes = Paste::where('user_id', \Auth::user()->id)->get();

            if ($pastes->count() > 0) {
                $destinationPath = 'uploads/temp';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $filename = $user->name . '-' . date('Y-m-d') . '-' . str_random(5) . '.zip';
                $file_path = $destinationPath . '/' . $filename;

                $zip = new \ZipArchive;
                $zip->open($file_path, \ZipArchive::CREATE);

                foreach ($pastes as $paste) {
                    $zip->addFromString($paste->title_f . '-' . $paste->slug . '.txt', $paste->content_bf);
                }
                $zip->addFromString('ReadMe.txt', __('Thank you for hosting your pastes on') . ' ' . config('settings.site_name') . ' - ' . url('/'));
                $zip->setArchiveComment(__('Thank you for hosting your pastes on') . ' ' . config('settings.site_name') . ' - ' . url('/'));
                $zip->close();

                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=' . $filename);
                header('Content-Length: ' . filesize($file_path));
                return readfile($file_path);
            } else {
                return redirect()->back()->withErrors(__('You do not have any pastes to backup'));
            }

        } else {
            return redirect()->back()->withErrors(__('Please enter valid password'));
        }
    }

    public function pasteSettingsShow()
    {
        $popular_syntaxes = \App\Models\Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug', 'extension']);
        $syntaxes = \App\Models\Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug', 'extension']);

        $paste = new \stdClass();
        $paste->title = (!empty(\Auth::user()->default_paste->title))?\Auth::user()->default_paste->title:"";
        $paste->status = (!empty(\Auth::user()->default_paste->status))?\Auth::user()->default_paste->status:"";
        $paste->syntax = (!empty(\Auth::user()->default_paste->syntax))?\Auth::user()->default_paste->syntax:config('settings.default_syntax');
        $paste->expire = (!empty(\Auth::user()->default_paste->expire))?\Auth::user()->default_paste->expire:"";
        $paste->password = (!empty(\Auth::user()->default_paste->password))?\Auth::user()->default_paste->password:"";
        $paste->encrypted = (!empty(\Auth::user()->default_paste->encrypted))?\Auth::user()->default_paste->encrypted:"";

        return view('front.user.paste_settings', compact('popular_syntaxes', 'syntaxes', 'paste'))->with('page_title', __('Paste Settings'));
    }

    public function pasteSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|numeric|in:1,2,3',
            'syntax' => 'nullable|exists:syntax,slug',
            'expire' => 'nullable|max:3|in:N,10M,1H,1D,1W,2W,1M,6M,1Y,SD',
            'title' => 'nullable|max:80|eco_string',
            'password' => 'nullable|max:50|string',
            'encrypted' => 'nullable|numeric|in:1'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }
        $user = User::findOrfail(\Auth::user()->id);

        if ($request->encrypted == 1) {
            $encrypted = 1;
        } else {
            $encrypted = 0;
        }

        $paste = new \stdClass();
        $paste->title = $request->title;
        $paste->status = $request->status;
        $paste->syntax = $request->syntax;
        $paste->expire = $request->expire;
        $paste->password = $request->password;
        $paste->encrypted = $encrypted;

        $user->default_paste = $paste;
        $user->save();

        return redirect()->back()->withSuccess(__('Your paste settings successfully saved'));
    }
}
