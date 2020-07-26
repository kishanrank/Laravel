<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Events\Admin\ActivationCodeEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivationCode;
use App\Notifications\Admin\AdminVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ActivationController extends Controller
{
    public function activation(AdminActivationCode $code)
    {
        $code->admin()->update([
            'active' => true,
            'email_verified_at' => now()
        ]);

        $admin = $code->admin; //due to model propery belongsTo we have admin data 
        $code->delete();
        Notification::send($admin, new AdminVerified($admin->name));
        $notification = array(
            'message' => 'Your account is now activated successfully. Please Log-in.',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.login')->with($notification);
    }

    public function resend(Request $request)
    {
        $admin = Admin::whereEmail($request->email)->firstOrFail();
        if ($admin->isAdminActivated()) {
            return redirect('/admin/home');
        }
        if (!$admin->adminActivationCode) {
            return view('errors.404');
        }
        // $url = route('admin.activate.account', ['code' => $admin->adminActivationCode->code]);
        // if (!$url) {
        //     return view('errors.404');
        // }
        event(new ActivationCodeEvent($admin));
        $notification = array(
            'message' => 'Email verification link resend successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.login')->with($notification);
    }
}
