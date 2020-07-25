<?php

namespace App\Http\Controllers;

use App\Models\ActivationCode;
use App\Events\ActivationCodeEvent;
use App\Notifications\UserVerified;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ActivationCodeController extends Controller
{
    public function activation(ActivationCode $code)
    { 
        $code->user()->update([
            'active' => true,
            'email_verified_at' => now()
        ]);

        $user = $code->user; //due to model propery belongsTo we have user data 
        $code->delete();
        Notification::send($user, new UserVerified());
        return redirect('/login')->with('success', 'Your account is now activated successfully. Please Log-in.');
    }

    public function resend(Request $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();
        if ($user->isUserActivated()) {
            return redirect('/admin/home');
        }
        $url = route('activate.account', ['code' => $user->userActivationCode->code]);
        if (!$url) {
            return view('errors.404');
        }
        event(new ActivationCodeEvent($user));
        // Notification::send($user, new AccountActivation($url));
        $notification = array(
            'message' => 'Email verification link resend successfully.', 
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notification);
    }
}
