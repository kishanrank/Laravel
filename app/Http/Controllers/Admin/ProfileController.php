<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponserController;
use App\Models\Admin;
use App\Models\Profile;
use App\Rules\MatchOldAdminPassword;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends ResponserController
{
    public function index()
    {
        return view('admin.peoples.admins.profile', ['admin' => Auth::guard('admin')->user()]);
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
            $old_path = public_path($admin->profile->avatar);
            if (File::exists($old_path)) {
                File::delete($old_path);
            }
            $avatar_save_path = public_path('/uploads/avatars');
            $img = Image::make($avatar->getRealPath());
            $avatar_new_name = strtolower(str_replace(' ', '_', $admin->name) . '_' . $avatar->getClientOriginalName());
            $img->resize(350, 350)->save($avatar_save_path . '/' . $avatar_new_name);
            $admin->profile->avatar = 'uploads/avatars/' . $avatar_new_name;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->profile->linkedin = $request->linkedin;
        $admin->profile->github = $request->github;
        $admin->profile->about = $request->about;
        $admin->save();
        $admin->profile->save();

        return redirect(route('admin.profile'))->with([
            'message' => 'Profile has been updated successfully.',
            'alert-type' => 'success'
        ]);
    }

    public function updatePassword(Request $request)
    {
        if ($request->ajax()) {
            $error = Validator::make($request->all(), Profile::passwordChangeRules());
            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

            $admin->password = bcrypt($request->password);
            if ($admin->save()) {
                return $this->successMessageResponse('Password updated successfully.');
            }
            return $this->errorMessageResponse('Error in changing password.');
        }
    }
}
