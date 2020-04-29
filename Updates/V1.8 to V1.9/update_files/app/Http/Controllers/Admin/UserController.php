<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Datatables;
use Hash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index')->with('page_title', 'Users');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'role', 'status', 'created_at']);
            return Datatables::of($users)
                ->editColumn('role', function ($user) {
                    return ($user->role == 1) ? 'Administrator' : 'Registered User';
                })
                ->addColumn('status', function ($user) {
                    if ($user->status == 0) {
                        return '<span class="text-danger">Inactive</span>';
                    } elseif ($user->status == 1) {
                        return '<span class="text-success">Active</span>';
                    } else {
                        return '<span class="text-red">Banned</span>';
                    }

                })
                ->addColumn('action', function ($user) {
                    return '<a class="btn btn-sm btn-default" href="' . url('admin/users/' . $user->id . '/edit') . '"><i class="fa fa-edit"></i> Edit</a> <a class="btn btn-sm btn-danger" href="' . url('admin/users/' . $user->id . '/delete') . '"><i class="fa fa-trash"></i> Delete</a>';
                })
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.user.create')->with('page_title', 'Users');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'              => 'required|alpha_num|min:3|max:20|unique:users,name',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|max:50|confirmed',
            'role'                  => 'required|numeric|in:1,2',
            'active'                => 'required|numeric|in:0,1,2',
            'password_confirmation' => '',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user                  = new User();
            $user->name            = $request->username;
            $user->email           = $request->email;
            $user->role            = $request->role;
            $user->status          = $request->active;
            if($request->status == 1){
                $user->email_verified_at = date('Y-m-d H:i:s');
            }
            $user->password        = Hash::make($request->password);

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

            $user->save();
            return redirect()->back()->withSuccess('Successfully created.');
        }
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.user.edit', compact('user'))->with('page_title', 'Users');
    }

    public function update($id, Request $request)
    {
        $user      = User::where('id', $id)->firstOrfail();
        $validator = Validator::make($request->all(), [
            'username'              => 'required|alpha_num|min:3|max:20|unique:users,name,' . $user->id,
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'password'              => 'nullable|min:6|string|confirmed',
            'password_confirmation' => 'sometimes',
            'role'                  => 'required|numeric|in:1,2',
            'active'                => 'required|numeric|in:0,1,2',
            'avatar'                => 'sometimes|mimes:jpeg,jpg,png|max:1024',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user->name   = $request->username;
            $user->email  = $request->email;
            $user->role   = $request->role;
            $user->status = $request->active;
            if($request->status == 1 && empty($user->email_verified_at)){
                $user->email_verified_at = date('Y-m-d H:i:s');
            }            
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
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

            $user->save();
            return redirect()->back()->withSuccess('Successfully updated.');
        }
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->withSuccess('User Successfully deleted.');
    }
}
