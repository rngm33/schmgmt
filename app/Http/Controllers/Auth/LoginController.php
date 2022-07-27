<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Redirect;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], true)) {
            if(Auth::user()->user_type == '2'){
                return Redirect::route('manager')->with('alert-success', 'Login success! Please enjoy!!');
            }
            elseif(Auth::user()->user_type == '1'){
                return Redirect::route('home')->with('alert-success', 'Login success! Please enjoy!!');
            }
            else{
                return Redirect::route('login')->with('alert-success', 'Login success! Please enjoy!!');
            }
        }  else {
            $this->incrementLoginAttempts($request);
             return Redirect::route('login')->with('alert-danger', 'Your username or password do not match!!');
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}
