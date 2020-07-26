<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public $maxAttempts = 5;

    public $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login', [
            'title' => 'Admin Login',
            'loginRoute' => 'admin.postlogin',
            'forgotPasswordRoute' => 'admin.password.request',
        ]);
    }

    public function login(Request $request)
    {
        $this->validator($request);

        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            //Fire the lockout event
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {

            return $this->authenticated($request, Auth::guard('admin')->user());
            // return redirect()->intended(route('admin.home'));
        }

        $this->incrementLoginAttempts($request);

        return $this->loginFailed();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with('status', 'Admin has been logged out!');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    private function loginFailed()
    {
        $notification = array(
            'message' => 'Login failed, please try again!',
            'alert-type' => 'error'
        );
        return redirect()
            ->back()
            ->withInput()
            ->with($notification);
    }

    public function username()
    {
        return 'email';
    }

    protected function authenticated(Request $request, $admin)
    {
        if (!$admin->isAdminActivated()) {
            Auth::guard('admin')->logout();
            $notification = array(
                'message' => 'Your account is not activated yet please activate first. </br> Need a link? <a class="resend-link" href="' . route('admin.resend.code') . '?email=' . $admin->email . '">Resend code</a>',
                'alert-type' => 'error'
            );
            return redirect('/admin/login')->with($notification);
        }
        return redirect()->intended(route('admin.home'));
    }
}
