<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\Syntax;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', \Carbon\Carbon::now())->orWhereNull('expire_time');
        })->where(function ($query) {
            $query->orWhereNull('user_id');
            $query->orWhereHas('user', function ($user) {
                $user->whereIn('status', [0, 1]);
            });
        })->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at', 'password', 'expire_time', 'views']);

        $popular_syntaxes = Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug','extension']);
        $syntaxes         = Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug','extension']);

        if (\Auth::check()) {
            $my_recent_pastes = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(config('settings.my_recent_pastes_limit'))->get(['title', 'syntax', 'slug', 'created_at', 'password', 'expire_time', 'views']);
        } else {
            $my_recent_pastes = [];
        }

        return view('front.home.index', compact('my_recent_pastes', 'recent_pastes', 'syntaxes', 'popular_syntaxes'));
    }
}
