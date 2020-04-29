<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\Report;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Validator;

class PasteController extends Controller
{
    public function show($slug)
    {
        $paste = Paste::where('slug', $slug)->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }


        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($paste->id, $already_viewed)) {
                array_push($already_viewed, $paste->id);
                $paste->views = $paste->views + 1;
                $paste->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$paste->id];
            session(['already_viewed' => $already_viewed]);
            $paste->views = $paste->views + 1;
            $paste->save();
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }


        $recent_pastes = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.show', compact('paste', 'recent_pastes','my_recent_pastes'))->with('page_title', $paste->title_f);
    }

    public function store(Request $request)
    {
        if(config('settings.public_paste') != 1) return redirect()->back()->withErrors(__('Public pasting is currently disabled.'));
        $captcha = (config('settings.captcha') == 1)?'required|captcha':'';
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:1',
            'status'  => 'required|numeric|in:1,2,3',
            'syntax'  => 'required|exists:syntax,slug',
            'expire'  => 'required|max:3|in:N,10M,1H,1D,1W,2W,1M,6M,1Y',
            'title'   => 'nullable|max:80|string',
            'password'=> 'nullable|max:50|string',
            'g-recaptcha-response' => $captcha
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }
        $content_size = strlen($request->content) / 1000;

        if($content_size > config('settings.max_content_size_kb')){
            return redirect()->back()->withErrors('Max allowed content size is '.config('settings.max_content_size_kb').'kb.')->withInput();
        }

        $ip_address = request()->ip();

        if(\Auth::check()){
            $paste_count = Paste::where('ip_address',$ip_address)->whereDate('created_at',date("Y-m-d"))->count();
            if($paste_count >= config('settings.daily_paste_limit_auth')){
                return redirect()->back()->withErrors(__('Daily paste limit reached.'))->withInput();
            }
        }
        else{
            $paste_count = Paste::where('ip_address',$ip_address)->whereDate('created_at',date("Y-m-d"))->count();
            if($paste_count >= config('settings.daily_paste_limit_unauth')){
                return redirect()->back()->withErrors(__('Daily paste limit reached, Please login to increase your paste limit.'))->withInput();
            }
        }

        $paste         = new Paste();
        $paste->title  = $request->title;
        $paste->slug   = str_random(10);
        $paste->syntax = (!empty($request->syntax)) ? $request->syntax : "markup";

        switch ($request->expire) {
            case '10M':
                $expire = '10 minutes';
                break;

            case '1H':
                $expire = '1 hour';
                break;

            case '1D':
                $expire = '1 day';
                break;

            case '1W':
                $expire = '1 week';
                break;

            case '2W':
                $expire = '1 week';
                break;

            case '1M':
                $expire = '1 month';
                break;

            case '6M':
                $expire = '6 months';
                break;

            case '1Y':
                $expire = '1 year';
                break;

            default:
                $expire = 'N';
                break;
        }

        if ($expire != 'N') {
            $paste->expire_time = date('Y-m-d H:i:s', strtotime('+' . $expire));
        }

        $paste->status  = $request->status;

        if (\Auth::check()) {
            $paste->user_id = \Auth::user()->id;
        }
        $paste->ip_address = $ip_address;

        if($request->password) {
            $paste->password = \Hash::make($request->password);
        }

        if($request->encrypted)
        {
            $paste->encrypted = 1;
            $paste->content = encrypt($request->content);

        }
        else {
            $paste->content = htmlentities($request->content);
        }

        $paste->save();

        return redirect($paste->url)->withSuccess(__('Paste successfully created.'));
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'sometimes|min:2|max:100|string',
        ]);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator);
        }
        
        $search_term = $request->keyword;
        $pastes = Paste::where(function($q) use ($search_term){
                $q->orWhere('title','like','%'.$search_term.'%');
                $q->orWhere('content','like','%'.$search_term.'%');
                $q->orWhere('syntax','like','%'.$search_term.'%');

        })->where('status', 1)->orderBy('created_at', 'desc')->paginate(20, ['title', 'syntax', 'slug', 'created_at']);


        $recent_pastes = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.search', compact('pastes', 'recent_pastes','my_recent_pastes'))->with('page_title', __('Search Results'));
    }

    public function archive($slug)
    {
        $syntax        = Syntax::where('slug', $slug)->firstOrfail(['name', 'slug']);
        $pastes        = Paste::where('syntax', $slug)->where('status', 1)->orderBy('created_at', 'DESC')->limit(50)->get();
        $recent_pastes = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.archive', compact('pastes', 'recent_pastes', 'syntax','my_recent_pastes'))->with('page_title', $syntax->name . ' '.__('Archive'));
    }

    public function archiveList()
    {
        $syntaxes      = Syntax::where('active', 1)->orderby('name')->get(['name', 'slug']);
        $recent_pastes = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.archive_list', compact('syntaxes', 'recent_pastes','my_recent_pastes'))->with('page_title', __('Archive'));
    }

    public function myPastes()
    {
        $pastes        = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(20);
        $recent_pastes = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        return view('front.paste.my_pastes', compact('pastes', 'recent_pastes'))->with('page_title', __('My Pastes'));
    }

    public function raw($slug)
    {
        if(config('settings.feature_raw') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $paste = Paste::where('slug', $slug)->whereNUll('password')->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }
        return response($paste->content_f, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function download($slug)
    {
        if(config('settings.feature_download') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $paste = Paste::where('slug', $slug)->whereNUll('password')->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }        

        $extension = (isset($paste->language)) ? $paste->language->extension_f : 'txt';
        $response  = response($paste->content_f, 200, [
            'Content-Disposition' => 'attachment; filename="' . $paste->title_f . '.' . $extension . '"',
        ]);

        return $response;
    }

    public function clone ($slug) {
        if(config('settings.feature_clone') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $paste = Paste::where('slug', $slug)->whereNUll('password')->firstOrfail(['syntax','content','encrypted','status','expire_time','title']);
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }

        $recent_pastes    = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        $popular_syntaxes = Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug']);
        $syntaxes         = Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.clone', compact('paste', 'recent_pastes', 'syntaxes', 'popular_syntaxes','my_recent_pastes'));
    }

    public function embed($slug)
    {
        if(config('settings.feature_embed') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $paste = Paste::where('slug', $slug)->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }

        return view('front.paste.embed', compact('paste'))->with('page_title', $paste->title_f . ' '.__('Embed '));
    }

    public function print($slug) {
        if(config('settings.feature_print') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $paste = Paste::where('slug', $slug)->whereNUll('password')->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }

        return view('front.paste.print', compact('paste'))->with('page_title', $paste->title_f . ' '.__('Print '));
    }

    public function edit($slug)
    {
        $paste = Paste::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }

        $recent_pastes    = Paste::where('status', 1)->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        $popular_syntaxes = Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug']);
        $syntaxes         = Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug']);

        if(\Auth::check()){
            $my_recent_pastes    = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at']);
        }
        else{
            $my_recent_pastes = [];
        }

        return view('front.paste.edit', compact('paste', 'recent_pastes', 'syntaxes', 'popular_syntaxes','my_recent_pastes'));
    }

    public function update($slug, Request $request)
    {
        $paste = Paste::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title_f . ' '.__('Paste is expired.'));
            }
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|min:1',
            'status'  => 'required|numeric|in:1,2,3',
            'syntax'  => 'required|exists:syntax,slug',
            'title'   => 'sometimes|max:80',
            'password'=> 'nullable|max:50|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }

        $content_size = strlen($request->content) / 1000;

        if($content_size > config('settings.max_content_size_kb')){
            return redirect()->back()->withErrors('Max allowed content size is '.config('settings.max_content_size_kb').'kb.')->withInput();
        }


        $paste->title       = $request->title;
        $paste->syntax      = (!empty($request->syntax)) ? $request->syntax : "markup";
        $paste->status      = $request->status;

        if($request->password) {
            $paste->password = \Hash::make($request->password);
        }

        if($request->encrypted)
        {
            $paste->encrypted = 1;
            $paste->content = encrypt($request->content);

        }
        else {
            $paste->content = htmlentities($request->content);
        }

        $paste->save();

        return redirect($paste->url)->withSuccess(__('Paste successfully updated.'));
    }

    public function destroy($slug)
    {
        $paste = Paste::where('slug', $slug)->where('user_id', \Auth::user()->id)->firstOrfail(['id','slug']);
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        $paste->delete();
        return redirect('my-pastes')->withSuccess(__('Paste successfully deleted.'));
    }

    public function report(Request $request)
    {
        if(config('settings.feature_report') != 1) return redirect()->back()->withErrors(__('This feature is disabled.'));
        $validator = Validator::make($request->all(), [
            'id'     => 'required|numeric|exists:pastes,id',
            'reason' => 'required|string|min:10|max:1000',

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $report           = new Report();
        $report->paste_id = $request->id;
        $report->user_id  = \Auth::user()->id;
        $report->reason   = $request->reason;
        $report->save();

        return redirect()->back()->withSuccess(__('Paste successfully reported.'));
    }

    public function getPaste(Request $request)
    {
        $paste = Paste::where('slug',$request->slug)->whereNotNull('password')->firstOrfail();
        if ($paste->status == 3) {
            if (\Auth::check()) {
                if ($paste->user_id != \Auth::user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if(password_verify($request->password, $paste->password)) {

            if($paste->encrypted == 1){
                $paste->content = decrypt($paste->content);
            }

            $response = ["status"=> "success", "content"=> html_entity_decode($paste->content)];
        }
        else{
            $message = '<div class="alert alert-danger">'.__('Please enter valid password.').'</div>';
            $response = ["status"=> "error", "message"=> $message];
        }

        return response()->json($response);
    }


}
