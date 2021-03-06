<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends Controller
{
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
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
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

        $user->save();
        return redirect()->back()->withSuccess(__('Profile successfully updated'));
    }
}
