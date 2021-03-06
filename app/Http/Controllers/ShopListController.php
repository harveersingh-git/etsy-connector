<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\EtsyConfig;
use App\Models\Country;
use App\Models\DownloadHistory;
use App\Models\AllowLicense;
use Spatie\Permission\Models\Role;

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
            // dd();
            $request->validate([
                // 'key_string' => 'required',
                // 'shared_secret' => 'required',
                'shop_name' => 'required',
                // 'user_name' => 'required',
                // 'app_url' => 'required|url',
            ]);
            $allow_licenec = AllowLicense::where('user_id', $input['id'])->latest()->first();
            $total_shop = EtsyConfig::where('user_id', $input['id'])->count();
            if (isset($allow_licenec['allowed_shops'])) {
                if ($allow_licenec['allowed_shops'] <= $total_shop) {
                    return redirect('shoplist/' . $id)->with('error', 'Your shop add limit exceeded. So please upgrade your license.');
                }
            } else {
                return redirect('shoplist/' . $id)->with('error', 'Your shop add limit exceeded. So please upgrade your license.');
            }


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
                'language' => isset($input['language']) ? ($input['language']) : ''
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
        $roles = auth()->user()->getRoleNames()[0];
        // dd(   $roles);
        try {
            $country = Country::orderBy('name', 'ASC')->get();
            $data = EtsyConfig::find(base64_decode($id));

            if ($data) {
                if ($roles == 'Admin') {
                    return view('shop.admin_edit', compact('id', 'data', 'country'));
                } else {
                    return view('shop.edit', compact('id', 'data', 'country'));
                }
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
            // 'key_string' => 'required',
            // 'shared_secret' => 'required',
            'shop_name' => 'required',
            // 'user_name' => 'required',
            // 'app_url' => 'required|url',
            // 'language' => 'required'

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
            'language' => isset($input['language']) ? ($input['language']) : '',
        ];

        $data = EtsyConfig::updateOrCreate(['id' =>     $input['id']], $array);
        $roles = auth()->user()->getRoleNames()[0];
        if ($roles == 'Admin') {
            return redirect('shop-list/')->with('success', 'Shop updated Successfully');
        } else {
            return redirect('shoplist/' . $data['user_id'])->with('success', 'Shop updated Successfully');
        }
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

        $etsy_shop  = EtsyConfig::find($id);
        if ($etsy_shop) {
            $download_history = DownloadHistory::where('shop_id', $id)->get();

            foreach ($download_history as $key => $val) {

                if (isset($val->file_name)) {
                    unlink(public_path('uploads/' . $val->file_name));
                } else {
                    unlink(public_path('uploads/' . $val->multi_lang_file_name));
                }
                DownloadHistory::find($val->id)->delete();
            }
            $etsy_shop->delete();
            return redirect()->route('subscriber.index')
                ->with('error', 'Record delete successfully');
        } else {
            return redirect()->route('subscriber.index')
                ->with('error', 'Record not delete successfully');
            // }
        }
    }

    public function shopList()
    {
        $data = EtsyConfig::with('owner')->get();

        return view('shop.shop_list', compact('data'));
    }


    public function shopListTrash(Request $request, $id = null)
    {
        $data = EtsyConfig::where('user_id', $id)->onlyTrashed()->latest()->get();

        return view('shop.index', compact('data', 'id'));

        // ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function permanentlyDestroy(Request $request)
    {

        $id = $request['id'];

        $data = EtsyConfig::onlyTrashed()->find($id)->forceDelete();;
        if ($data) {

            return response()->json(['status' => 'success']);
        }
    }

    public function myShopRestore(Request $request)
    {

        $id = $request['id'];
        $shop = EtsyConfig::withTrashed()->find($id)->restore();

        if ($shop) {
            // subscriber::withTrashed()->where('user_id', $id)->restore();
            return response()->json(['status' => 'success']);
        }
    }
}
