<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'exists:users,' . $this->username() . ',active,1',
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => 'The selected email is invalid or the account has not been verified or enable.'
        ]);
        $remember = ($request->get('remember')) ? true : false;

        $auth = Auth::attempt(
            [
                'email'  => strtolower($request->get('email')),
                'password'  => $request->get('password')
            ],
            $remember
        );
        if ($auth) {

            return Redirect::to('home');
        } else {

            // validation not successful, send back to form 
            return Redirect::to('/')->with('flash_notice', 'Your username/password combination was incorrect.');
        }
    }
}
