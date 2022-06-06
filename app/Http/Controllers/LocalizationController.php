<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localization;
use File;
use URL;

class LocalizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = Localization::where('user_id', auth()->user()->id)->latest()->get();

        return view('localization.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $url = '';
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
                'value' => 'required',
                'file' => 'required',
            ]);
            $path = resource_path() . '/lang/' . $request['name'];
            File::makeDirectory($path, $mode = 0777, true, true);
            if (isset($request->file)) {


                $imageName = 'messages.php';
                $request->file->move($path, $imageName);
            }
            $input = [
                'user_id' => auth()->user()->id,
                'name' => isset($request['name']) ? ($request['name']) : '',
                'value' => isset($request['value']) ? ($request['value']) : '',
                'file' => isset($request['file']) ? ($imageName) : '',
            ];
            // $obj = new Localization();
            // $obj->create($request->all(), $imageName);
            Localization::create($input);

            return redirect('localization')->with('success', 'Localization added Successfully');
        }
        return view('localization.create', compact('url'));
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
    public function show(Request $reques, $id)
    {

        try {

            $data = Localization::find(base64_decode($id));

            if ($data) {
                return view('localization.edit', compact('id', 'data',));
            }
            return redirect('localization');
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
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
        // if ($request->isMethod('post')) {

        $request->validate([
            'name' => 'required',
            'value' => 'required',
            // 'file' => 'required',
        ]);
        $input = $request->all();

        if (isset($input->file)) {
            $imageName = 'messages.php';
            $input->file->move($path, $imageName);
        }
        $result =   Localization::find($input['id']);
        $path = resource_path() . '/lang/';

        $replace_folder = $path . $input['name'];
        $old_folder = $path . $result['name'];


        rename($old_folder,  $replace_folder);
        $array = [
            'user_id' => auth()->user()->id,
            'name' => isset($input['name']) ? ($input['name']) : '',
            'value' => isset($input['value']) ? ($input['value']) : '',
            'file' => isset($input['file']) ? ($imageName) : '',
        ];

        $data = Localization::updateOrCreate(['id' =>     $input['id']], $array);

        return redirect('localization')->with('success', 'Localization added Successfully');
        // }
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
        $obj =  new Localization();

        $obj->destory($request['id']);

        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }
}
