<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = Admin::REDIRECT_TO_AFTER_RESET_PASSWORD;

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset', [
            'passwordUpdateRoute' => 'admin.password.update',
            'token' => $token,
            'email' => $request->email
        ]);
    }

    protected function broker()
    {
        return Password::broker('admins');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        // event(new PasswordReset($user));

        // $this->guard()->login($user);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        $notification = array(
            'message' => 'Your account password has been successfully changed.',
            'alert-type' => 'success'
        );

        return redirect($this->redirectTo)
            ->with($this->setNotification('Your account password has been successfully changed.', 'success'));
    }
}
