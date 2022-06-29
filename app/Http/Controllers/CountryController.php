<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Country::orderBy('id', 'DESC')->get();

        return view('country.index', compact('data'));
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = '';
        return view('country.create', compact('roles'));
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
            'name' => 'required|unique:countries,name',
            'code' => 'required|unique:countries',

        ]);
        $user = Country::create($input);

        return redirect()->route('country.index')
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
        $user = Country::find($id);


        return view('country.edit', compact('user'));
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

            'name' => 'required|unique:countries,name,' . $id . ',id',
            'code' =>  'required|unique:countries,code,' . $id . ',id',

        ]);




        $user = Country::find($id);
        $user->update($input);

        return redirect()->route('country.index')
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

        $user = Country::find($id)->delete();
        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }
}
