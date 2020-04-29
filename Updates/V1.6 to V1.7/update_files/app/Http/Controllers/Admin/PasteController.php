<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\Syntax;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class PasteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pastes.index')->with('page_title', 'Pastes');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $pastes = Paste::select(['id', 'title', 'slug', 'user_id', 'syntax', 'expire_time', 'status', 'views','password','encrypted', 'created_at']);
            return Datatables::of($pastes)
                ->addColumn('check', function ($item) {
                    return '<input type="checkbox" class="check" name="check[]" value="' . $item->id . '">';
                })
                ->editColumn('title', function ($paste) {
                    return '<a href="' . $paste->url . '" target="_blank">' . $paste->title_f . '</a>';
                })
                ->addColumn('user', function ($paste) {
                    return (isset($paste->user)) ? '<a href="' . url('admin/users/' . $paste->user->id . '/edit') . '" target="_blank">' . $paste->user->name . '</a>' : 'Anonymous';
                })
                ->addColumn('status', function ($paste) {
                    if ($paste->status == 2) {
                        return '<span class="text-warning">Unlisted</span>';
                    } elseif ($paste->status == 1) {
                        return '<span class="text-success">Public</span>';
                    } else {
                        return '<span class="text-danger">Private</span>';
                    }

                }) 
                ->editColumn('encrypted', function ($paste) {
                    if ($paste->encrypted == 1) {
                        return '<span class="text-success">Yes</span>';
                    } else {
                        return '<span class="text-danger">No</span>';
                    }

                })                
                ->addColumn('password_protected', function ($paste) {
                    if (!empty($paste->password)) {
                        return '<i class="fa fa-lock text-danger"></i>';
                    } else {
                        return '-';
                    }

                })
                ->addColumn('action', function ($paste) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/pastes/' . $paste->id . '/edit') . '"><i class="fa fa-edit"></i> Edit</a> <a class="btn btn-sm btn-danger" href="' . url('admin/pastes/' . $paste->id . '/delete') . '"><i class="fa fa-trash"></i> Delete</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        $popular_syntaxes = Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug']);
        $syntaxes         = Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug']);
        return view('admin.pastes.create', compact('syntaxes', 'popular_syntaxes'))->with('page_title', 'Pastes');
    }

    public function edit($id)
    {
        $paste            = Paste::findOrfail($id);
        $popular_syntaxes = Syntax::where('active', 1)->where('popular', 1)->get(['name', 'slug']);
        $syntaxes         = Syntax::where('active', 1)->where('popular', 0)->get(['name', 'slug']);

        if($paste->encrypted == 1){
            $paste->content = decrypt($paste->content);
        }

        return view('admin.pastes.edit', compact('paste', 'syntaxes', 'popular_syntaxes'))->with('page_title', 'Pastes');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:1',
            'status'  => 'required|numeric|in:1,2,3',
            'syntax'  => 'required|exists:syntax,slug',
            'expire'  => 'required|max:3|in:N,10M,1H,1D,1W,2W,1M,6M,1Y,SD',
            'title'   => 'nullable|max:80|clean_string',
            'password' => 'nullable|max:50|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }
        $ip_address = request()->ip();

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

            case 'SD':
                $expire = 'SD';
                break;

            default:
                $expire = 'N';
                break;
        }

        if ($expire != 'N') {
            if($expire == 'SD') $paste->self_destroy = 1;
            else $paste->expire_time = date('Y-m-d H:i:s', strtotime('+' . $expire));
        }

        $paste->status  = $request->status;
        $paste->content = htmlentities($request->content);
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

        return redirect()->back()->withSuccess('Paste successfully created.');
    }

    public function update($id, Request $request)
    {
        $paste = Paste::where('id', $id)->firstOrfail();

        $validator = Validator::make($request->all(), [
            'content' => 'required|min:1',
            'status'  => 'required|numeric|in:1,2,3',
            'syntax'  => 'required|exists:syntax,slug',
            'title'   => 'nullable|max:80|clean_string',
            'password' => 'nullable|max:50|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
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
            $paste->encrypted = 0;
            $paste->content = htmlentities($request->content);
        }      

        $paste->save();

        return redirect()->back()->withSuccess('Paste successfully updated.');
    }

    public function destroy($id)
    {
        Paste::where('id', $id)->delete();
        return redirect('admin/pastes')->withSuccess('Paste Successfully deleted.');
    }

    public function deleteSelected(Request $request)
    {
        if (!empty($request->ids)) {
            Paste::whereIn('id', $request->ids)->delete();
            echo "success";
        } else {
            echo "error";
        }
    }
}
