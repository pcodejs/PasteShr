<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;

class SettingController extends Controller
{
    public function edit()
    {
        $data     = Setting::get(['key', 'value'])->toArray();
        $settings = array();
        foreach ($data as $d) {
            $settings[$d['key']] = $d['value'];
        }

        return view('admin.settings.index', compact('settings'))->with('page_title', 'Settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name'           => 'required|min:2|max:20',
            'site_email'          => 'required|email|max:100',
            'meta_keywords'       => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
            'recent_pastes_limit' => 'required|numeric|min:1|max:20',
            'max_content_size_kb' => 'required|numeric|min:1|max:1000',
            'ad'                  => 'required|numeric|in:0,1',
            'ad1'                 => 'nullable|max:1000',
            'ad2'                 => 'nullable|max:1000',
            'ad3'                 => 'nullable|max:1000',
            'footer_text'         => 'nullable|max:2000',
            'social_fb'           => 'nullable|max:255',
            'social_tw'           => 'nullable|max:255',
            'social_gp'           => 'nullable|max:255',
            'social_lin'          => 'nullable|max:255',
            'social_insta'        => 'nullable|max:255',
            'social_pin'          => 'nullable|max:255',
            'public_paste'          => 'required|numeric|in:0,1',
            'registration_open'          => 'required|numeric|in:0,1',
            'captcha'          => 'required|numeric|in:0,1',
            'captcha_site_key'          => 'nullable|max:255',
            'captcha_secret_key'          => 'nullable|max:255',
            'disqus'				=> 'required|numeric|in:0,1',
            'disqus_code'			=> 'nullable|max:3000',
            'default_locale'        => 'required|exists:languages,code',
            'default_timezone'      => 'required|timezone'

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        Setting::where('key', 'site_name')->update(['value' => $request->site_name]);
        Setting::where('key', 'site_email')->update(['value' => $request->site_email]);
        Setting::where('key', 'meta_keywords')->update(['value' => $request->meta_keywords]);
        Setting::where('key', 'meta_description')->update(['value' => $request->meta_description]);
        Setting::where('key', 'recent_pastes_limit')->update(['value' => $request->recent_pastes_limit]);
        Setting::where('key', 'max_content_size_kb')->update(['value' => $request->max_content_size_kb]);
        Setting::where('key', 'ad')->update(['value' => $request->ad]);
        Setting::where('key', 'ad1')->update(['value' => $request->ad1]);
        Setting::where('key', 'ad2')->update(['value' => $request->ad2]);
        Setting::where('key', 'ad3')->update(['value' => $request->ad3]);
        Setting::where('key', 'footer_text')->update(['value' => $request->footer_text]);
        Setting::where('key', 'social_fb')->update(['value' => $request->social_fb]);
        Setting::where('key', 'social_tw')->update(['value' => $request->social_tw]);
        Setting::where('key', 'social_gp')->update(['value' => $request->social_gp]);
        Setting::where('key', 'social_lin')->update(['value' => $request->social_lin]);
        Setting::where('key', 'social_insta')->update(['value' => $request->social_insta]);
        Setting::where('key', 'social_pin')->update(['value' => $request->social_pin]);
        Setting::where('key', 'registration_open')->update(['value' => $request->registration_open]);
        Setting::where('key', 'public_paste')->update(['value' => $request->public_paste]);
        Setting::where('key', 'captcha')->update(['value' => $request->captcha]);
        Setting::where('key', 'captcha_site_key')->update(['value' => $request->captcha_site_key]);
        Setting::where('key', 'captcha_secret_key')->update(['value' => $request->captcha_secret_key]);
        Setting::where('key', 'disqus')->update(['value' => $request->disqus]);
        Setting::where('key', 'default_locale')->update(['value' => $request->default_locale]);
        Setting::where('key', 'default_timezone')->update(['value' => $request->default_timezone]);
        Setting::where('key', 'disqus_code')->update(['value' => htmlentities($request->disqus_code)]);

        return redirect()->back()->withSuccess('Settings successfully updated.');
    }
}
