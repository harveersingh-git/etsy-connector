<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Socialite;
use App\Models\User;
use App\Models\SocialAccount;
use DB;
use Illuminate\Auth\Events\Verified;


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


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        // if ($request['error'] == 'access_denied') {

        //     return redirect()->to('/');
        // } else {
        $user = $this->createOrGetUser(Socialite::driver($provider)->stateless()->user(), $provider);

        Auth::login($user);

        return redirect()->to('/home');
        // }
    }

    /**
     * Create or get a user based on provider id.
     *
     * @return Object $user
     */
    private function createOrGetUser($providerUser, $provider)
    {
        // dd($providerUser);
        $account = SocialAccount::where('provider', $provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();

        if ($account) {
            //Return account if found
            return $account->user;
        } else {

            //Check if user with same email address exist
            $user = User::where('email', $providerUser->getEmail())->first();
            // dd($providerUser);
            //Create user if dont'exist
            $name = explode(' ', $providerUser->getName());
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $name[0],
                    'last_name' => isset($name[1]) ? $name[1] : '',
                    'password' => '',
                    'country_code' => '00',
                    'mobile' => rand(1111111111, 9999999999),
                    'email_verified_at' => date('Y-m-d H:s:i'),
                    'active' => '1'
                ]);

                $user->assignRole('Subscriber');
                event(new Verified($user));
            }

            //Create social account
            $user->social_accounts()->create([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);

            return $user;
        }
    }
}
