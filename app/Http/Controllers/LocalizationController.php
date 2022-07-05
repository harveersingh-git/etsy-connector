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
        if ($request->method() == 'POST') {
            $request->validate([
                'name' => 'required|string',
                'value' => 'required|string',
                'country_flag' => 'required|image|mimes:jpeg,png,jpg|max:1000',

            ]);
            if (isset($request->country_flag)) {
                $country_flag = time() . '.' . $request->country_flag->extension();
                $request->country_flag->move(public_path('flag'), $country_flag);
            }
            // File::copy(Input::file('file'), 'new/location/file.txt');
            $file1 = $request->file;
            $file2 = $request->file;
            $path = resource_path() . '/lang/' . $request['name'];
            // dd($path);

            File::makeDirectory($path, $mode = 0777, true, true);

            $fileName = 'messages.php';
            $fileName1 = 'messages.txt';

            File::copy($request->file, $path . '/messages.php');
            File::copy($request->file, $path . '/messages.txt');

            Localization::create([
                'name' => $request->name,
                'value' => $request->value,
                'user_id' => auth()->user()->id,
                'file' => $fileName,
                'country_flag' => isset($country_flag) ? $country_flag : ''
            ]);

            return redirect('/localization')->with('success', 'Record updated successfully');
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

        // $language = Localization::find($id);
        if ($request->method() == 'POST') {
            $request->validate([
                'name' => 'required|string',
                'value' => 'required|string',

            ]);
            Localization::find($request->id)->delete();
            if (isset($request->country_flag)) {
                $country_flag = time() . '.' . $request->country_flag->extension();
                $request->country_flag->move(public_path('flag'), $country_flag);
            }


            // File::copy(Input::file('file'), 'new/location/file.txt');
            $file1 = $request->file;
            $file2 = $request->file;
            $path = resource_path() . '/lang/' . $request['name'];
            // dd($path);
            if ($request->file) {
                File::deleteDirectory(resource_path('/lang/' . $request->name));
                $directory = File::makeDirectory($path, $mode = 0777, true, true);
            }
            $fileName = 'messages.php';
            $fileName1 = 'messages.txt';
            if ($request->file) {
                File::copy($request->file, $path . '/messages.php');
                File::copy($request->file, $path . '/messages.txt');
            }


            Localization::create([
                'name' => $request->name,
                'value' => $request->value,
                'user_id' => auth()->user()->id,
                'file' => $fileName,
                'country_flag' => isset($country_flag) ? $country_flag : ''
            ]);

            return redirect('/localization')->with('success', 'Record updated successfully');
        }
        // return view('localization.edit',compact('language'));
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

        // File::deleteDirectory(resource_path('/lang/' . $obj->name));
        $obj->destory($request['id']);

        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }
}
