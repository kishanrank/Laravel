<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->isUserActivated()) {
            $this->guard()->logout();
            $notification = array(
                'message' => 'Your account is not activated yet please activate first. </br> Need a link? <a class="resend-link" href="' . route('resend.code') . '?email=' . $user->email . '">Resend code</a>',
                'alert-type' => 'error'
            );
            return redirect('/login')->with($notification);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
