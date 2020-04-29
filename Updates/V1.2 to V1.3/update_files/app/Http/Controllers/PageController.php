<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Paste;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Validator;
use Mail;

class PageController extends Controller
{

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('active', 1)->firstOrfail();
        return view('front.page.show', compact('page'))->with('page_title', $page->title);
    }

    public function contact()
    {
        return view('front.page.contact')->with('page_title', __('Contact Us'));
    }

    public function contactPost(Request $request)
    {        
        $captcha = (config('settings.captcha') == 1)?'required|captcha':'';
        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:2|max:100',
            'email'   => 'required|email',
            'message' => 'required|min:10|max:200',
            'g-recaptcha-response' => $captcha
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            Mail::send('emails.contact', ['request' => $request], function ($m) {
                $m->to(config('settings.site_email'))->subject(config('settings.site_name') . ' - '.__('Contact Message'));
            });

            return redirect('contact')->with('success', __('Your message successfully sent.'));
        }

    }

    public function sitemap()
    {
        $pages = Page::where('active',1)->get(['slug']);
        $pastes = Paste::where('status',1)->orderBy('created_at','DESC')->limit(100)->get(['id','slug']);
        $syntaxes = Syntax::where('active',1)->get(['slug']);
        return response()->view('front.page.sitemap', compact('pages','pastes','syntaxes'))->header('Content-Type', 'text/xml');
    }    
}