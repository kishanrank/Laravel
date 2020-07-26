<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponserController;
use App\Models\Admin;

class ProfileController extends ResponserController
{

    public function index()
    {
        return view('admin.peoples.admins.profile', ['user' => Auth::guard('admin')->user()]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'linkedin' => 'required|url',
            'github' => 'required|url',
            'about' => 'required'
        ]);

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatar_new_name = time() . $avatar->getClientOriginalName();
            $avatar->move('uploads/avatars', $avatar_new_name);
            $admin->profile->avatar = 'uploads/avatars/' . $avatar_new_name;
            // $user->profile->save();
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->profile->linkedin = $request->linkedin;
        $admin->profile->github = $request->github;
        $admin->profile->about = $request->about;
        if ($request->has('password')) {
            $password = trim($request->password);
            if ($password != null) {
                $admin->password = bcrypt($password);
            }
        }

        $admin->save();
        $admin->profile->save();

        return redirect(route('user.profile'))->with([
            'message' => 'Profile has been updated successfully.',
            'alert-type' => 'success'
        ]);
    }
}
