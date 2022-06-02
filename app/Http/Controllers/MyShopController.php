<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtsyConfig;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;

class MyShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = EtsyConfig::where('user_id', auth()->user()->id)->latest()->get();

        return view('my-shop.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $url = '';

        $id = auth()->user()->id;

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


            return redirect('my-shop')->with('success', 'Shop added Successfully');
        }
        return view('my-shop.create', compact('url', 'country', 'id'));
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
            $country = Country::orderBy('name', 'ASC')->get();
            $data = EtsyConfig::find(base64_decode($id));

            if ($data) {
                return view('my-shop.edit', compact('id', 'data', 'country'));
            }
            return redirect('my-shop');
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

        $data = EtsyConfig::find($id);



        return view('my-shop.edit', compact('data'));
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
            'status' => isset($input['status']) ? ($input['status']) : '1',
        ];

        $data = EtsyConfig::updateOrCreate(['id' =>     $input['id']], $array);


        return redirect('my-shop')->with('success', 'Shop updated Successfully');
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
        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }
}
