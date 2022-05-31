<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\EtsyConfig;
use App\Models\Country;

class ShopListController extends Controller
{
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
    public function index(Request $request, $id = null)
    {

        $data = EtsyConfig::where('user_id', $id)->latest()->get();

        return view('shop.index', compact('data', 'id'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null)
    {

        $url = '';

        $id = $id;

        $country = Country::orderBy('name', 'ASC')->get();
        if ($request->isMethod('post')) {
            $input = $request->all();
            $request->validate([
                'key_string' => 'required',
                'shared_secret' => 'required',
                'shop_name' => 'required',
                'user_name' => 'required',
                'app_url' => 'required|url',
            ]);

            $input = [
                'user_id' => isset($input['id']) ? ($input['id']) : '',
                'app_url' => isset($input['app_url']) ? ($input['app_url']) : '',
                'key_string' => isset($input['key_string']) ? ($input['key_string']) : '',
                'shared_secret' => isset($input['shared_secret']) ? ($input['shared_secret']) : '',
                'access_token_secret' => isset($input['access_token_secret']) ? ($input['access_token_secret']) : '',
                'access_token' => isset($input['access_token']) ? ($input['access_token']) : '',
                'shop_name' => isset($input['shop_name']) ? ($input['shop_name']) : '',
                'user_name' => isset($input['user_name']) ? ($input['user_name']) : '',
                'country_id' => isset($input['country_id']) ? ($input['country_id']) : '',
                'store_id' => isset($input['store']) ? ($input['store']) : '',
            ];

            $data = EtsyConfig::create($input);


            return redirect('shoplist/' . $id)->with('success', 'Shop added Successfully');
        }
        return view('shop.create', compact('url', 'country', 'id'));
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = EtsyConfig::find($id);



        return view('shop.edit', compact('data'));
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
            $country = Country::orderBy('name', 'ASC')->get();
            $data = EtsyConfig::find(base64_decode($id));

            if ($data) {
                return view('shop.edit', compact('id', 'data', 'country'));
            }
            return redirect('subscriber');
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
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


        $input = $request->all();

        $request->validate([
            'key_string' => 'required',
            'shared_secret' => 'required',
            'shop_name' => 'required',
            'user_name' => 'required',
            'app_url' => 'required|url',

        ]);

        $array = [
            // 'id' => isset($input['current_id']) ? ($input['current_id']) : '',
            // 'user_id' => isset($input['id']) ? ($input['id']) : '',
            'app_url' => isset($input['app_url']) ? ($input['app_url']) : '',
            'key_string' => isset($input['key_string']) ? ($input['key_string']) : '',
            'shared_secret' => isset($input['shared_secret']) ? ($input['shared_secret']) : '',
            'access_token_secret' => isset($input['access_token_secret']) ? ($input['access_token_secret']) : '',
            'access_token' => isset($input['access_token']) ? ($input['access_token']) : '',
            'shop_name' => isset($input['shop_name']) ? ($input['shop_name']) : '',
            'user_name' => isset($input['user_name']) ? ($input['user_name']) : '',
            'country_id' => isset($input['country_id']) ? ($input['country_id']) : '',
            'store_id' => isset($input['store']) ? ($input['store']) : '',
        ];

        $data = EtsyConfig::updateOrCreate(['id' =>     $input['id']], $array);


        return redirect('shoplist/' . $data['user_id'])->with('success', 'Shop updated Successfully');
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

        EtsyConfig::find($id)->delete();

        return redirect()->route('subscriber.index')
            ->with('success', 'Record delete successfully');
    }
}
