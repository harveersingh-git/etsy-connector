<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtsySettings;

class EtsySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = EtsySettings::orderBy('id', 'DESC')->get();

        return view('EtsySettings.index', compact('data'));
        // ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = '';
        return view('EtsySettings.create', compact('roles'));
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
            'app_url' => 'required',
            'key_string' => 'required',
            'shared_secret' => 'required'

        ]);
        $user = EtsySettings::create($input);

        return redirect()->route('etsy-setting.index')
            ->with('success', 'Record created successfully');
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
        // dd('sdf');
        $user = EtsySettings::find($id);


        return view('EtsySettings.edit', compact('user'));
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

        // $this->validate($request, [

        //     'name' => 'required|unique:countries,name,' . $id . ',id',
        //     'code' =>  'required|unique:countries,code,' . $id . ',id',

        // ]);
        $this->validate($request, [
            'app_url' => 'required',
            'key_string' => 'required',
            'shared_secret' => 'required'

        ]);
        $input = $request->all();



        $user = EtsySettings::find($id);
        $user->update($input);

        return redirect()->route('etsy-setting.index')
            ->with('success', 'Record updated successfully');
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

        $user = EtsySettings::find($id)->delete();
        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }
}
