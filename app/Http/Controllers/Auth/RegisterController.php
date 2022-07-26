<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use App\Models\subscriber;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (isset($data['business'])) {


            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
                // 'password_confirmation' => ['required', 'string', 'min:8', 'confirmed'],
                // 'country_code' => ['required'],
                'mobile' => ['unique:users'],
                'state' => 'required',
                'city' => 'required',
                'zip' => 'required',
                'country' => 'required',
                'address' => 'required',
                'tax_id' => 'required',

            ]);
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
                // 'password_confirmation' => ['required', 'string', 'min:8', 'confirmed'],
                // 'country_code' => ['required'],
                'mobile' => ['unique:users'],
                'state' => 'required',
                'city' => 'required',
                'zip' => 'required',
                'country' => 'required',
                'address' => 'required',


            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $account_type = (isset($data['business'])) ? '1' : '0';
        $user =  User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'country_code' => isset($data['mobile']) ? $data['country_code'] : '',
            'mobile' => isset($data['mobile']) ? $data['mobile'] : '',
            'password' => Hash::make($data['password']),
            'business_account' => $account_type,
            'tax_id' => isset($data['tax_id']) ? $data['tax_id'] : '',
            'active' => '0',
            // 'country_id' => isset($data['country']) ? $data['country'] : '',
        ]);
        $user->assignRole('Subscriber');
        if ($user) {
            $array = [
                'address' => isset($data['address']) ? $data['address'] : '',
                'user_id' =>  $user->id,
                'city' => isset($data['city']) ? $data['city'] : '',
                'state' =>   isset($data['state']) ? $data['state'] : '',
                'zip' => isset($data['zip']) ? $data['zip'] : '',
                'auto_email_update' => isset($data['auto_email_update']) ? '1' : '0',
                'country_id' => isset($data['country']) ? $data['country'] : '',
            ];
            subscriber::create($array);
        }
        try {
            $res = [
                'subject' => 'Account Register Successfully',
                'email' => $data['email'],

            ];
            Mail::send('emails.account_create', $res, function ($message) use ($res) {
                $message->to($res['email'])
                    ->subject($res['subject']);
            });
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return $user;
    }
}
