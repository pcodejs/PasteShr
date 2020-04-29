<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Paste;
use App\Models\Syntax;
use App\User;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $syntax_active   = Syntax::where('active', 1)->count();
        $syntax_inactive = Syntax::where('active', 0)->count();

        $pages_active   = Page::where('active', 1)->count();
        $pages_inactive = Page::where('active', 0)->count();

        $paste_public   = Paste::where('status', 1)->count();
        $paste_unlisted = Paste::where('status', 2)->count();
        $paste_private  = Paste::where('status', 3)->count();

        $user_active   = User::where('status', 1)->count();
        $user_inactive = User::where('status', 0)->count();
        $user_banned   = User::where('status', 2)->count();

        $users = User::orderBy('created_at', 'DESC')->limit(6)->get(['id', 'name', 'created_at', 'avatar']);

        return view('admin.dashboard.index', compact('syntax_inactive', 'syntax_active', 'paste_public', 'paste_unlisted', 'paste_private', 'user_active', 'user_inactive', 'user_banned', 'pages_inactive', 'pages_active', 'users'))->with('page_title', 'Dashboard');
    }

    public function showLogin()
    {
        if (\Auth::check()) {
            if (\Auth::user()->role == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('/');
            }

        }
        return view('admin.auth.login')->with('page_title', 'Admin Login');
    }
}
