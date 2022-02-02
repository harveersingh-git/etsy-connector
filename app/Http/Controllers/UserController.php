<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use Validator;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Change password functinality
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error", "Your current password does not matches with the password.");
            }

            if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
                // Current password and new password same
                return redirect()->back()->with("error", "New Password cannot be same as your current password.");
            }

            $validatedData = $request->validate([
                'current-password' => 'required',
                'new-password' => 'required|string|min:8|confirmed',
            ]);

            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();

            return redirect()->back()->with("success", "Password successfully changed!");
        }
        return view('user.change-password');
    }




    /**
     * view and edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request)
    {
        $input = $request->all();
        $id = Auth::user()->id;
        $user = User::find($id);

        if ($request->isMethod('post')) {
            // $validator = Validator::make($request->all(), [
            //     'name' => 'required',
            //     'email' => 'required'

            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'status' =>
            //         false, 'message' => $validator->errors()->first(),
            //         'Data' => '',
            //         'Status_code' => "401"
            //     ]);
            // }
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'last_name' => 'required',
            ]);
            if (isset($request->profile_image)) {
                $imageName = time().'.'.$request->profile_image->extension();
                $request->profile_image->move(public_path('profile_images'), $imageName);
          
                $array = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'mobile' => $input['mobile'],
                    'last_name' => $input['last_name'],
                    'profile_image' =>  $imageName,
                ];
            } else {
                $array = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'mobile' => $input['mobile'],
                    'last_name' => $input['last_name'],
                ];
            }
       
            $user->update($array);


            return redirect()->back()->with("success", "Record successfully changed!");
        }
        return view('user.view', compact('id', 'user'));
    }
}
