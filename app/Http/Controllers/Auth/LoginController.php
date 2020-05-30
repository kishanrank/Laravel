<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /*
    public function redirectTo()
    {
        if (Auth::user()->admin) {
            return '/admin/home';
        }
        return '/login';
    }
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request)
    // {   
    //     $input = $request->all();
   
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
   
    //     if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
    //     {
    //         if (auth()->user()->admin == 1) {
    //             return redirect()->route('admin.home');
    //         }else{
    //             return redirect()->route('login');
    //         }
    //     }else{
    //         return redirect()->route('login')
    //             ->with('error','Email-Address And Password Are Wrong.');
    //     }    
    // }

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
