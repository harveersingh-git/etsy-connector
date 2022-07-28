<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{

    public function test(Request $request)
    {
        $url= '';
        return view('emails.verify',compact('url'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = "";
        $query = ContactUs::latest();
        if (isset($request['search'])) {
            $query->where('name', 'like', '%' . $request['search'] . '%');
            $query->orWhere('mobile', 'like', '%' . $request['search'] . '%');
            $query->orWhere('email', 'like', '%' . $request['search'] . '%');
            $query->orWhere('subject', 'like', '%' . $request['search'] . '%');
            $query->orWhere('message', 'like', '%' . $request['search'] . '%');
        }
        $data = $query->orderBy('id', 'DESC')->get();

        return view('support.index', compact('data', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $url = '';
        if ($request->method() == 'POST') {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'country_code' => 'required',
                'mobile' => 'required',
                'subject' => 'required',
                'message' => 'required'

            ]);
            ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'country_code' => $request->country_code,
                'mobile' => $request->mobile,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            return redirect('/contect-us')->with('success', 'The query has been sent successfully.
            ');
        }
        return view('auth.contact-us', compact('url'));
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
        $id = base64_decode($id);
        $data = ContactUs::find($id);

        return view('support.edit', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request['id'];
        $input = $request->all();
    
        if (isset($input['status'])) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }
        $res = ContactUs::find($id);
        $res->update($input);

        return redirect()->route('support')
            ->with('success', 'Record updated successfully');
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

    public function phpinfo(){

        echo phpinfo();
        die;
    }
}
