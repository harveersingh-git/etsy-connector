<?php

namespace App\Http\Controllers;

use App\Models\subscriber;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use App\Models\Country;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Mail;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Models\AllowLicense;
use App\Models\Status;

// use App\Modals\



class SubscriberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:subscriber-list|subscriber-create|subscriber-edit|subscriber-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:subscriber-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscriber-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscriber-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::with(['current_status', 'subscribe_details', 'allow'])->whereHas('roles', function ($query) {
            $query->where('name', 'Subscriber');
        })->where('active', '1')->orderBy('id', 'DESC')->get();


        $trash_user = User::with('subscribe_details')->onlyTrashed()->whereHas('roles', function ($query) use ($request) {
            $query->where('name', 'Subscriber');
        })->latest()->get();
        // dd($data->toarray());

        return view('subscriber.index', compact('data', 'trash_user'));
    }


    public function subscriberInActive(Request $request)
    {
        $data = User::with('subscribe_details')->whereHas('roles', function ($query) {
            $query->where('name', 'Subscriber');
        })->where('active', '0')->orderBy('updated_at', 'DESC')->get();
        return view('subscriber.index', compact('data'));
    }


    public function subscriberTrash(Request $request)
    {

        $data = User::with('subscribe_details')->onlyTrashed()->whereHas('roles', function ($query) use ($request) {
            $query->where('name', 'Subscriber');
        })->orderBy('updated_at', 'DESC')->get();
        // dd(    $trashUser->toArray());
        return view('subscriber.index', compact('data'));
        // ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $country = Country::orderBy('name', 'ASC')->get();
        return view('subscriber.create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'mobile' => 'unique:users',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            // 'code' => 'required',
            'address' => 'required',
        ]);
        if (isset($request['business'])) {
            $this->validate($request, [
                'tax_id' => 'required',
            ]);
        }
        $account_type = (isset($request['business'])) ? '1' : '0';
        $input['password'] = Hash::make($input['password']);
        $input['name'] = $input['first_name'];
        $input['country_code'] = isset($input['mobile']) ? $input['code'] : '';
        $input['mobile'] = isset($input['mobile']) ? $input['mobile'] : '';
        $user = User::create($input);

        // $role =  Role::where('name', 'Subscriber')->first();
        $user->assignRole('Subscriber');
        if ($user) {
            $fields = [
                'user_id' =>  $user->id,
                'city' => isset($input['city']) ? $input['city'] : '',
                'state' =>   isset($input['state']) ? $input['state'] : '',
                'zip' => isset($input['zip']) ? $input['zip'] : '',
                'auto_email_update' => isset($input['auto_email_update']) ? '1' : '0',
                'country_id' => isset($input['country']) ? $input['country'] : '',
                'address' => isset($input['address']) ? $input['address'] : '',
                'business_account' => $account_type,
                'tax_id' => isset($input['tax_id']) ? $input['tax_id'] : '',
            ];
            subscriber::create($fields);
        }
        event(new Registered($user));
        $data = [
            'subject' => 'Account Register Successfully',
            'email' => $input['email'],
            // 'content' => 'test'
        ];
        $success =  Mail::send('emails.account_create', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject($data['subject']);
        });
        return redirect()->route('subscriber.index')
            ->with('success', 'Subscriber created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::with('subscribe_details')->find($id);
        $status = Status::get();
        // dd( $user->toArray());
        $country = Country::orderBy('name', 'ASC')->get();
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('subscriber.edit', compact('status', 'user', 'roles', 'userRole', 'country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'mobile' =>  'unique:users,mobile,' . $id . ',id',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'code' => 'required',
            'address' => 'required'
        ]);

        if (isset($request['business'])) {
            $this->validate($request, [
                'tax_id' => 'required',
            ]);
        }
        if (!empty($input['password'])) {
            $request->validate([
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
            ]);
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $account_type = (isset($input['business'])) ? '1' : '0';



        $user = User::find($id);
        $input['country_code'] = isset($input['code']) ? $input['code'] : $user['country_code'];
        $input['mobile'] = isset($input['mobile']) ? $input['mobile'] : $user['country_code'];
        $input['business_account'] = $account_type;
        $input['tax_id'] =  isset($input['tax_id']) ? $input['tax_id'] : '';
        $user->update($input);

        subscriber::where('user_id', $id)->delete();
        $fields = [
            'user_id' =>  $id,
            'city' => isset($input['city']) ? $input['city'] : '',
            'state' =>   isset($input['state']) ? $input['state'] : '',
            'zip' => isset($input['zip']) ? $input['zip'] : '',
            'auto_email_update' => isset($input['auto_email_update']) ? '1' : '0',
            'country_id' => isset($input['country']) ? $input['country'] : '',
            'address' => isset($input['address']) ? $input['address'] : '',
        ];
        subscriber::create($fields);



        return redirect()->route('subscriber.index')
            ->with('success', 'Subscriber updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request['id'];

        $user = User::find($id);
        // dd($subscriber );
        $userId =   $user->id;
        $user->delete();
        $subscriber = subscriber::where('user_id', $userId)->first();
        $subscriber->delete();
        return redirect()->route('subscriber.index')
            ->with('success', 'Subscriber is de-activate successfully');
    }


    public function sendVerificationLink(Request $request)
    {
        $id = $request['id'];

        $user = User::find($id)->sendEmailVerificationNotification();;
        // dd( $user  );
        // event(new Registered($user));
        return response()->json(['status' => 'success']);
    }

    public function userRestore(Request $request)
    {

        $id = $request['id'];
        $status = ($request['status'] == 'active' ? '1' : '0');
        $user = User::withTrashed()->find($id)->restore();
        $data = User::find($id);
        $data->update(['active' => $status]);
        if ($user) {
            subscriber::withTrashed()->where('user_id', $id)->restore();
            return response()->json(['status' => 'success']);
        }
    }
    public function permanentlyDestroy(Request $request)
    {

        $id = $request['id'];

        $data = User::onlyTrashed()->find($id)->forceDelete();;
        if ($data) {
            // subscriber::onlyTrashed()->where('user_id', $id)->forceDelete();
            // $data->forceDelete();
            return response()->json(['status' => 'success']);
        }
    }


    public function subscriberStatusUpdate(Request $request)
    {

        $id = $request['id'];

        $data = User::find($id);
        if ($data) {

            $status = ($data->active == '0' ? '1' : '0');
            // dd(    $status);
            $data->update(['active' => $status]);

            return response()->json(['status' => 'success', 'data' => $data]);
        }
    }

    public function changePassword(Request $request, $id = null)
    {
        $input = $request->all();

        if ($request->isMethod('post')) {
            $id = $input['id'];

            if (!empty($input['password'])) {
                $request->validate([
                    'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:8',
                ]);
                $input['password'] = Hash::make($input['password']);
            }

            $user = User::find($id);

            $user->update($input);
            return redirect()->route('subscriber.index')->with("success", "Password update successfully.");
        }
        return view('subscriber.change_password', compact('id'));
    }



    public function license(Request $request, $id)
    {

        $url = '';
        $id = base64_decode($id);
        $user = User::with('allow')->find($id);
        if ($request->isMethod('post')) {
            $input = $request->all();

            $request->validate([
                'expire_date' => 'required',
                'license' => 'required',
                'id' => 'required',
                'allowed_shops' => 'required',
            ]);

            if ($input['license'] == '1') {
                $user = User::find($id);
                $user->update(['license' => '1']);

                $input = [
                    'allowed_shops' => isset($input['allowed_shops']) ? $input['allowed_shops'] : '0',
                    'user_id' => isset($id) ? ($id) : '',
                    'license' => isset($input['license']) ? ('1') : '0',
                    'expire_date' => isset($input['expire_date']) ? (Carbon::parse($input['expire_date'])->format('Y-m-d')) : '',
                ];
                $data = AllowLicense::create($input);
                return redirect()->back()->with(['success' => "Your licence allow successfully."]);
            } else {
                return redirect()->back()->with(['error' => "Your licence not allow successfully."]);
            }
        }
        return view('subscriber.license', compact('url', 'id', 'user'));
    }
}
