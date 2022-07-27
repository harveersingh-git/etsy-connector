<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;


class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Status::where('name', '!=', 'New')->orderBy('id', 'DESC')->get();

        return view('Status.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = '';
        return view('Status.create', compact('roles'));
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
            'name' => 'required',
        ]);

        $input['user_id'] = Auth::user()->id;

        Status::create($input);
        return redirect()->route('status.index')
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
        $user = Status::find($id);


        return view('Status.edit', compact('user'));
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
            'name' => 'required'

        ]);


        $user = Status::find($id);
        $user->update($input);

        return redirect()->route('status.index')
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

        $user = Status::find($id)->delete();
        return response()->json(['status' => 'success']);
    }

    public function statusRestore(Request $request)
    {

        $id = $request['id'];
        $shop = Status::withTrashed()->find($id)->restore();

        if ($shop) {

            return response()->json(['status' => 'success']);
        }
    }


    public function permanentlyDestroy(Request $request)
    {

        $id = $request['id'];

        $data = Status::onlyTrashed()->find($id)->forceDelete();;
        if ($data) {
            // subscriber::onlyTrashed()->where('user_id', $id)->forceDelete();
            // $data->forceDelete();
            return response()->json(['status' => 'success']);
        }
    }

    public function statusTrash(Request $request)
    {
        $data = Status::where('name', '!=', 'New')->onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('Status.index', compact('data'));
    }
}
