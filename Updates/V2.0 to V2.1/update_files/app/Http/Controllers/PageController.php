<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Paste;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Mail;
use Validator;

class PageController extends Controller
{

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('active', 1)->firstOrfail();

        $description = trim(preg_replace('/\s+/', ' ', $page->content));

        $page->description = str_limit($description, 200, '...');

        return view('front.page.show', compact('page'))->with('page_title', $page->title);
    }

    public function contact()
    {
        return view('front.page.contact')->with('page_title', __('Contact Us'));
    }

    public function contactPost(Request $request)
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
            'message'              => 'required|eco_long_string|min:10|max:5000',
            'g-recaptcha-response' => $captcha,
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            try {
                Mail::send('emails.contact', ['request' => $request], function ($m) {
                    $m->to(config('settings.site_email'))->subject(config('settings.site_name') . ' - ' . __('Contact Message'));
                });
            } catch (\Exception $e) {
                return redirect('contact')->with('warning', __('Your message was not sent due to invalid mail configuration'));
            }

            return redirect('contact')->with('success', __('Your message successfully sent'));
        }

    }

    public function sitemap()
    {
        $pages  = Page::where('active', 1)->get(['slug']);
        $pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', \Carbon\Carbon::now())->orWhereNull('expire_time');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })
        ->orderBy('created_at', 'DESC')->limit(100)->get(['id', 'slug']);
        $syntaxes = Syntax::where('active', 1)->get(['slug']);
        return response()->view('front.page.sitemap', compact('pages', 'pastes', 'syntaxes'))->header('Content-Type', 'text/xml');
    }
}
