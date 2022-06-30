<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EtsyConfig;
use App\Models\EtsyProduct;
use App\Models\DownloadHistory;
use App\Models\EtsySettings;
use App\Models\ProductHistory;
use Validator;
use Http;
use Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;






class EtsyController extends Controller
{

    /**
     * 
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     * Create a etsy configration.
     *
     * @return void
     */
    public function etsyConfig(Request $request, $id = null)
    {
        return redirect()->back();
        $role =  Auth::user()->roles->pluck('name')[0];
        if ($role != 'Admin' && isset($id)) {
            return redirect()->back()->with("error", "You are not autherized user to acces this url. !");
        }

        $input = $request->all();

        if (isset($id) || isset($input['id'])) {
            $id = isset($input['id']) ? $input['id'] : $id;

            $user = EtsyConfig::where('id', $id)->first();
        } else {
            $id = Auth::user()->id;

            $user = EtsyConfig::where('user_id', $id)->first();
        }

        $country = Country::orderBy('name', 'ASC')->get();

        if ($request->isMethod('post')) {

            $request->validate([
                'key_string' => 'required',
                'shared_secret' => 'required',
                'shop_name' => 'required',
                'user_name' => 'required',

            ]);

            $array = [
                'user_id' => $id,
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

            if ($user) {

                $user->update($array);
            } else {

                EtsyConfig::create($array);
            }





            return redirect()->back()->with("success", "Record successfully changed!");
        }
        return view('etsy.view', compact('id', 'user', 'country'));
    }


    /**
     * 
     * Create a etsy auth.
     *
     * @return void
     */

    public function etsyAuth(Request $request)
    {

        // $id = Auth::user()->id;
        $id = $request['id'];

        $result = EtsySettings::where('id', $id)->first();
        // $result = EtsySettings::where('status', '1')->first();
        // $result = EtsyConfig::where('user_id', $id)->first();
        if ($result) {
            $keystring = $result['key_string'];
            $shared_secret = $result['shared_secret'];
            // $api_url = "http://openapi.etsy.com/v2/";
            $appurl = $result['app_url'];
            $calback_url = "https://www.example.com/some/location";
            $oauth = new \OAuth($keystring, $shared_secret);
            $oauth->disableSSLChecks();
            $req_token = $oauth->getRequestToken($appurl . "oauth/request_token?scope=email_r%20listings_r", 'oob', "GET");

            if (!empty($req_token)) {
                $auth_url = $req_token['login_url'];
                $oauth_token = trim($req_token['oauth_token']);
                $oauth_token_secret = trim($req_token['oauth_token_secret']);
                $id = Auth::user()->id;
                // $user = EtsyConfig::where('user_id', $id)->first();
                $array = [
                    'access_token_secret' => isset($oauth_token_secret) ? ($oauth_token_secret) : '',
                    'access_token' => isset($oauth_token) ? ($oauth_token) : '',
                ];

                $result->update($array);

                return response()->json(['status' => 'success', 'data' =>  $auth_url]);
            }
        } else {
            return response()->json(['status' => 'error', 'data' => '']);
        }
    }

    /**
     * 
     * Create a etsy auth.
     *
     * @return void
     */

    public function etsyShopLang(Request $request)
    {

        $id = $request['id'];
        $result = EtsyConfig::where('id', $id)->first();
        $language = [
            'de' => 'German', 'en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'it' => 'Italian', 'ja' => 'Japanese', 'nl' => 'Dutch', 'pl' => 'Polish',
            'pt' => 'Portuguese', 'ru' => 'Russian'
        ];

        // $result = EtsyConfig::where('user_id', $id)->first();
        if ($result) {
            return response()->json(['status' => 'success', 'data' =>  $result, 'language' => $language]);
        } else {
            return response()->json(['status' => 'error', 'data' => '']);
        }
    }

    /**
     * 
     * Create a verify access code
     *
     * @return void
     */

    public function verifyAccessCode(Request $request)
    {

        $verifier = $request['verify_token'];


        if ($verifier) {
            // $id = Auth::user()->id;
            $id = $request['id'];
            // $result = EtsyConfig::where('id', $id)->first();
            $result = EtsySettings::where('id', $id)->first();

            $keystring =  $result['key_string'];
            $shared_secret = $result['shared_secret'];
            $oauth_token =  $result['access_token'];
            $oauth_token_secret = $result['access_token_secret'];
            if (!empty($keystring) && !empty($shared_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {
                $oauth = new \OAuth($keystring, $shared_secret);
                $oauth->disableSSLChecks();
                $oauth->setToken($oauth_token, $oauth_token_secret);
                $appurl = $result['app_url'];
                $acc_token = $oauth->getAccessToken($appurl . "oauth/access_token", null, $verifier, "GET");

                if ($acc_token) {
                    $cedetsy_access_token_secret = $acc_token['oauth_token_secret'];
                    $cedetsy_token = $acc_token['oauth_token'];
                    $array = [
                        'api_access_token' => isset($cedetsy_token) ? ($cedetsy_token) : '',
                        'api_access_secret' => isset($cedetsy_access_token_secret) ? ($cedetsy_access_token_secret) : '',
                    ];

                    $result->update($array);
                    return response()->json(['status' => 'success', 'data' => '']);
                }
            }
        }
    }

    /**
     * 
     * Create a request for the authorization
     *
     * @return void
     */
    public function getRequestAuthorization()
    {
        $id = Auth::user()->id;
        // $result = EtsyConfig::where('user_id', $id)->first();
        $result = EtsyConfig::first();
        $ced_etsy_keystring       =  $result['key_string'];
        $ced_etsy_shared_secret   =  $result['shared_secret'];
        $access_token             =  $result['api_access_token'];
        $access_token_secret      =    $result['api_access_secret'];
        try {

            $client = new \Etsy\EtsyClient($ced_etsy_keystring, $ced_etsy_shared_secret);
            $client->authorize($access_token, $access_token_secret);
            $api = new \Etsy\EtsyApi($client);
            //    $country =  $api->findAllCountry();
            // dd(  $country);
            return $api;
        } catch (Throwable $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getFlag($lang)
    {
        $countrycode = json_decode(file_get_contents(public_path() . '/' . 'countryCode/countryFlag.json'));
        foreach ($countrycode as $key => $val) {
            if ($val->name === $lang) {
                return $val->image;
            }
        }
    }


    /**
     * 
     * get the product list form the etsy and sync the product
     *
     * @return void
     */
    public function etsyListData(Request $request, $id = null)
    {
        $url = '';
        $page = 1;
        $limit = 100;
        $data = [];
        $etsy_id = '';

        if ($request->isMethod('Get')) {

            $roles = Auth::user()->getRoleNames();

            if ($roles[0] == 'Admin') {

                $etsy_id = base64_decode($id);

                if (empty($etsy_id)) {

                    return redirect()->back();
                }

                $shops = EtsyConfig::where('id', $etsy_id)->get();

                $query = DownloadHistory::with(['shops', 'user']);
                if (isset($request['language']) && $request['language'] != null) {

                    $query->orWhere('language', $request['language']);
                }
                $data = $query->where('shop_id', $etsy_id)->get();
                // dd(      $data->toArray());
            } else {

                $shops = EtsyConfig::where('status', 1)->where('user_id', auth()->user()->id)->get();
                $shops_ids = $shops->pluck('id');

                $query =  DownloadHistory::with(['shops', 'user']);
                if (isset($request['language']) && $request['language'] != null) {

                    $query->where('language', $request['language']);
                }
                $data =   $query->where('user_id', auth()->user()->id)->whereIn('shop_id', $shops_ids)->get();


                // $data =  EtsyProduct::with('shops')->whereIn('shop_id', $shops_ids)->get();


            }
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'shop' => 'required',
            ]);

            $input_shop_id = $request['shop'];


            $sync_type = isset($request['sync_type']) ? $request['sync_type'] : 'Auto';
            $resultSetting = EtsySettings::first();
            $result = EtsyConfig::where('id', $request['shop'])->first();

            $language  =  isset($result['language']) ? $result['language'] : 'en';

            if ($result) {

                EtsyProduct::where('shop_id', $request['shop'])->delete();

                $key_string = $resultSetting['key_string'];
                $api_access_token = $resultSetting['api_access_token'];
                $shop_id = $result['shop_name'];
                $appurl = $resultSetting['app_url'];
                ////ddsdd

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $appurl . 'shops/' . $shop_id . '/listings/active?api_key=' . $key_string,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'x-api-key:' . $key_string,
                        'Authorization: Bearer ' . $api_access_token,
                        'Cookie: fve=1643640618.0; uaid=JYYRIuVpd8k7JhiFS1kUcXLRgoxjZACCxO_ftWB0tVJpYmaKkpWSU4VlREBwmXOBj19QsXNFgW9gvnliYURAQHlagFItAwA.; user_prefs=CFmwDxv3XIPcLuHsJleib85a6epjZACCxO_ftWB0tJKnX5CSTl5pTo6OUmqerruTkg5QCCpiBKFwEbEMAA..'
                    ),
                ));

                $response = curl_exec($curl);


                curl_close($curl);
                $totalProduct =  json_decode($response);

                if ($totalProduct->count) {
                    $limit = 100;
                    // $total_page = intval(round(160 / $limit));

                    if ($totalProduct->count > 100) {
                        $total_page = intval(round($totalProduct->count / $limit));
                    } else {
                        $total_page = 1;
                    }

                    ////
                    for ($i = 1; $i <= $total_page; $i++) {
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $appurl . 'shops/' . $shop_id . '/listings/active?api_key=' . $key_string . '&language=' . $language . '&page=' . $i . '&limit=' . $limit,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/x-www-form-urlencoded',
                                'x-api-key:' . $key_string,
                                'Authorization: Bearer ' . $api_access_token,
                                'Cookie: fve=1643640618.0; uaid=JYYRIuVpd8k7JhiFS1kUcXLRgoxjZACCxO_ftWB0tVJpYmaKkpWSU4VlREBwmXOBj19QsXNFgW9gvnliYURAQHlagFItAwA.; user_prefs=CFmwDxv3XIPcLuHsJleib85a6epjZACCxO_ftWB0tJKnX5CSTl5pTo6OUmqerruTkg5QCCpiBKFwEbEMAA..'
                            ),
                        ));

                        $response = curl_exec($curl);

                        curl_close($curl);
                        $response =  json_decode($response);

                        if (count($response->results) > 0) {
                            $product_data = array();


                            foreach ($response->results as $key => $value) {
                                if (isset($value->quantity) && $value->quantity > 0) {
                                    $product_data["availability"] = 'in stock';
                                } else {
                                    $product_data["availability"] = 'out of stock';
                                }
                                $product_data["brand"] = url('/');
                                $product_data["condition"] = 'new';

                                if (isset($value->listing_id)) {

                                    $product_data["image_url"] =   $this->productListImage($value->listing_id);
                                }

                                $product_data["quantity"] =  isset($value->quantity) ? $value->quantity : '0';
                                $product_data["title"] = isset($value->title) ? $value->title : '';
                                $product_data["description"] = isset($value->description) ? $value->description : '';
                                $product_data["price"] = isset($value->price) ? $value->price : '';
                                $product_data["currency_code"] = isset($value->currency_code) ? $value->currency_code : '';
                                $product_data["materials"] = isset($value->materials) ? implode(',', $value->materials) : '';
                                $product_data["shipping_template_id"] = isset($value->shipping_template_id) ? $value->shipping_template_id : '';
                                $product_data["taxonomy_id"] = isset($value->taxonomy_id) ? $value->taxonomy_id : '';
                                $product_data["shop_section_id"] = isset($value->shop_section_id) ? $value->shop_section_id : '';
                                $product_data["image_ids"] = isset($value->image_ids) ? implode(',', $value->image_ids) : '';
                                $product_data["is_customizable"] = isset($value->is_customizable) ? $value->is_customizable : '';
                                $product_data["non_taxable"] = isset($value->non_taxable) ? $value->non_taxable : '';
                                $product_data["image"] = isset($value->image) ? $value->image : '';
                                $product_data["state"] = isset($value->state) ? $value->state : '';
                                $product_data["processing_min"] = isset($value->processing_min) ? $value->processing_min : '';
                                $product_data["processing_max"] = isset($value->processing_max) ? $value->processing_max : '';
                                $product_data["tags"] = isset($value->tags) ? implode(',', $value->tags) : '';
                                $product_data["who_made"] = isset($value->who_made) ? $value->who_made : '';
                                $product_data["is_supply"] = isset($value->is_supply) ? $value->is_supply : '';
                                $product_data["when_made"] = isset($value->when_made) ? $value->when_made : '';
                                $product_data["style"] = isset($value->style) ? implode(',', $value->style) : '';
                                $product_data["listing_id"] = isset($value->listing_id) ? $value->listing_id : '';
                                $product_data["url"] = isset($value->url) ? str_replace('www.etsy.com', strtolower($shop_id) . '.etsy.com', $value->url) : '';
                                $product_data["user_id"] = auth()->user()->id;
                                $product_data["shop_id"] = $request['shop'];
                                EtsyProduct::updateOrCreate(['listing_id' => $value->listing_id], $product_data);

                                $product_data["date"] = Carbon::now()->toDateString();
                                $final_array[] = $product_data;
                            }
                        }
                    }

                    $download_history_id =   $this->exportCsv($input_shop_id, $language, $sync_type);


                    if (count($final_array) > 0) {
                        foreach ($final_array as $value) {
                            $value["download_histories_id"] = $download_history_id->id;
                            ProductHistory::create($value);
                        }

                        $this->exportMultiLangCsv($download_history_id->id);
                    }
                    return response()->json(['status' => 'success', 'data' =>  $totalProduct]);
                    // return redirect()->back()->with("success", "Product Sync successfully!");
                }
                return redirect()->back()->with("success", "Product sync successfully !");
            } else {
                return redirect()->back()->with("success", "Please check ETSY configration!");
            }
        }

        return view('etsy.product_list', compact('url', 'data', 'page', 'limit', 'shops', 'etsy_id'));
    }



    /**
     * 
     * generate the csv file according to the  Data feed fields and specifications for catalogues
     *
     * @return void
     */

    public function genrateCsv_old()
    {


        $date = Carbon::now()->toDateString();
        $click =  EtsyProduct::get();

        if (count($click) > 0) {

            $columns = ['id', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];
            $fileName = $date . '-' . auth()->user()->id . '-' . 'productlist.csv';
            // $filepath = public_path('uploads/');

            $tasks = $click;
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            // fclose($file);
            // move_uploaded_file($fileName, $filepath.$fileName);

            $callback = function () use ($tasks, $columns, $fileName) {
                $file = fopen("public/uploads/" . $fileName, 'w');

                fputcsv($file, $columns);
                foreach ($tasks as $data) {

                    $row['id']  = isset($data->listing_id) ? $data->listing_id : 'N/A';
                    $row['title']  = isset($data->title) ? substr($data->title, 0, 150) : 'N/A';
                    $row['description']  = isset($data->description) ? $data->description : 'N/A';
                    $row['price']  = isset($data->price) ? $data->price . ' ' . $data->currency_code : 'N/A';
                    $row['condition']  = isset($data->condition) ? $data->condition : 'N/A';
                    $row['availability']  = isset($data->availability) ? $data->availability : 'N/A';
                    $row['brand']  = isset($data->brand) ? $data->brand : 'N/A';
                    $row['link']  = isset($data->url) ? $data->url : 'N/A';
                    $row['image_link']  = isset($data->image_url) ? $data->image_url : 'N/A';


                    fputcsv($file, $row);
                }

                // file_put_contents("public/", $fileName);
                fclose($file);
            };
            if ($callback) {
                DownloadHistory::where('user_id', auth()->user()->id)->where('date', $date)->delete();

                $array = [
                    'user_id' => auth()->user()->id,
                    'file_name' => $fileName,
                    'date' =>  $date,

                ];
                DownloadHistory::create($array);
            }


            return response()->stream($callback, 200, $headers);
        }
    }


    /**
     * 
     * get the product list form the etsy
     *
     * @return void
     */
    public function productListImage($list_id)
    {

        // $list_id = "1197687199";

        // $data =  EtsyProduct::get();
        // if ($request->isMethod('post')) {
        $id = Auth::user()->id;
        $resultSetting =  EtsySettings::first();
        // $result = EtsyConfig::where('user_id', $id)->first();
        // dd( $result);
        if ($resultSetting) {
            $appurl = $resultSetting['app_url'];
            $key_string = $resultSetting['key_string'];
            $api_access_token = $resultSetting['api_access_token'];


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $appurl . 'listings/' . $list_id . '/images?api_key=' . $key_string,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $api_access_token,
                    'Cookie: fve=1643640618.0; uaid=JYYRIuVpd8k7JhiFS1kUcXLRgoxjZACCxO_ftWB0tVJpYmaKkpWSU4VlREBwmXOBj19QsXNFgW9gvnliYURAQHlagFItAwA.; user_prefs=CFmwDxv3XIPcLuHsJleib85a6epjZACCxO_ftWB0tJKnX5CSTl5pTo6OUmqerruTkg5QCCpiBKFwEbEMAA..'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $imageResponse =  json_decode($response);

            if (isset($imageResponse->results[0]->url_fullxfull)) {
                $image =  $imageResponse->results[0]->url_fullxfull;
            } else {
                $image = 'N/A';
            }
            return $image;
        }
    }


    public function downloadHistory()
    {

        $roles = Auth::user()->getRoleNames();
        if ($roles[0] == 'Admin') {
            $data = DownloadHistory::get();
        } else {

            $data = DownloadHistory::where('user_id', auth()->user()->id)->get();
        }
        return view('etsy.downloadhistory', compact('data'));
    }




    public function exportCsv($shop_name = null,  $language, $sync_type)
    {
        $total_language = [
            'de' => 'de_DE', 'en' => 'en_XX', 'es' => 'es_XX', 'fr' => 'fr_XX', 'it' => 'it_IT', 'ja' => 'ja_XX', 'nl' => 'nl_XX', 'pl' => 'pl_PL',
            'pt' => 'pt_XX', 'ru' => 'ru_RU'
        ];
        $url = '';
        // $roles = Auth::user()->getRoleNames();
        // if ($roles[0] == 'Admin') {
        //     $shops = EtsyConfig::get();
        // } else {
        //     $shops = EtsyConfig::where('user_id', auth()->user()->id)->get();
        // }
        // if ($request->isMethod('post')) {

        $date = Carbon::now()->toDateString();
        // $t = time();
        $rand = rand(100, 999);
        $click =  EtsyProduct::where('shop_id', $shop_name)->get();
        $get_name = EtsyConfig::find($shop_name);

        if (count($click) > 0) {

            $columns = ['id', 'override', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];

            // $fileName = $language . '-' . 'productlist.csv';
            $fileName = $get_name->shop_name . '-' . $rand  . '-' . 'productlist.csv';
            // $fileName = $date . '-' . $t . 'productlist.csv';
            // $filepath = public_path('uploads/');

            $tasks = $click;
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );


            // move_uploaded_file($fileName, $filepath.$fileName);

            // $callback = function () use ($tasks, $columns, $fileName) {
            // $file_current = fopen('php://output', 'w');
            $file = fopen("public/uploads/" . $fileName, 'w');

            // fputcsv($file_current, $columns);
            fputcsv($file, $columns);
            foreach ($tasks as $data) {

                $row['id']  = isset($data->listing_id) ? $data->listing_id : 'N/A';
                $row['override']  = $total_language[$language];
                $row['title']  = isset($data->title) ? substr($data->title, 0, 150) : 'N/A';
                $row['description']  = isset($data->description) ? $data->description : 'N/A';
                $row['price']  = isset($data->price) ? $data->price . ' ' . $data->currency_code : 'N/A';
                $row['condition']  = isset($data->condition) ? $data->condition : 'N/A';
                $row['availability']  = isset($data->availability) ? $data->availability : 'N/A';
                $row['brand']  = isset($data->brand) ? $data->brand : 'N/A';
                $row['link']  = isset($data->url) ? $data->url : 'N/A';
                $row['image_link']  = isset($data->image_url) ? $data->image_url : 'N/A';

                // fputcsv($file_current, $row);
                fputcsv($file, $row);
            }


            // fclose($file_current);

            // fclose($file_current);
            fclose($file);
            // };
            // if ($callback) {
            // DownloadHistory::where('user_id', auth()->user()->id)->where('date', $date)->delete();
            $array = [
                'user_id' => auth()->user()->id,
                'file_name' => $fileName,
                // 'multi_lang_file_name' => $fileName,
                'date' =>  $date,
                'shop_id' => $shop_name,
                'language' =>  $language,
                'sync_type' => $sync_type

            ];
            $data =   DownloadHistory::create($array);
            // }
            // return ob_get_clean();
            // return response()->stream($callback, 200, $headers);
            return $data;
        } else {
            return redirect()->back()->with("success", "No product found for the given shop !");
        }
        // }
        // return view('etsy.csv', compact('url', 'shops'));
    }



    public function exportMultiLangCsv($download_histories_id)
    {

        $total_language = [
            'de' => 'de_DE', 'en' => 'en_XX', 'es' => 'es_XX', 'fr' => 'fr_XX', 'it' => 'it_IT', 'ja' => 'ja_XX', 'nl' => 'nl_XX', 'pl' => 'pl_PL',
            'pt' => 'pt_XX', 'ru' => 'ru_RU'
        ];
        $url = '';
        // $roles = Auth::user()->getRoleNames();
        // if ($roles[0] == 'Admin') {
        //     $shops = EtsyConfig::get();
        // } else {
        //     $shops = EtsyConfig::where('user_id', auth()->user()->id)->get();
        // }
        // if ($request->isMethod('post')) {

        $date = Carbon::now()->toDateString();
        $t = time();
        $click =  ProductHistory::where('download_histories_id', $download_histories_id)->get();

        if (count($click) > 0) {
            $dhistory = DownloadHistory::find($download_histories_id);
            // dd( $dhistory);
            $columns = ['id', 'override', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];

            $fileName = $date . '-' . $t . 'productlist.csv';


            $tasks = $click;
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $file = fopen("public/uploads/" . $fileName, 'w');

            // fputcsv($file_current, $columns);
            fputcsv($file, $columns);
            foreach ($total_language  as $language_owerWrite) {
                foreach ($tasks as $data) {

                    $row['id']  = isset($data->listing_id) ? $data->listing_id : 'N/A';
                    $row['override']  = $language_owerWrite;
                    $row['title']  = isset($data->title) ? substr($data->title, 0, 150) : 'N/A';
                    $row['description']  = isset($data->description) ? $data->description : 'N/A';
                    $row['price']  = isset($data->price) ? $data->price . ' ' . $data->currency_code : 'N/A';
                    $row['condition']  = isset($data->condition) ? $data->condition : 'N/A';
                    $row['availability']  = isset($data->availability) ? $data->availability : 'N/A';
                    $row['brand']  = isset($data->brand) ? $data->brand : 'N/A';
                    $row['link']  = isset($data->url) ? $data->url : 'N/A';
                    $row['image_link']  = isset($data->image_url) ? $data->image_url : 'N/A';

                    // fputcsv($file_current, $row);
                    fputcsv($file, $row);
                }
            }



            fclose($file);
            // };
            $dhistory->update(['multi_lang_file_name' =>   $fileName]);
            return $file;
        } else {
            return redirect()->back()->with("success", "No product found for the given shop !");
        }
        // }
        // return view('etsy.csv', compact('url', 'shops'));
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

        $data =  DownloadHistory::find($id);
        $success =       $data->delete();
        if ($success) {
            if (\File::exists(public_path('uploads/' . $data->file_name))) {
                \File::delete(public_path('uploads/' . $data->file_name));
            }
        }

        return response()->json(['status' => 'success']);
        // return redirect()->route('subscriber.index')
        //     ->with('success', 'Record delete successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $reques, $id)
    {

        try {
            $url = '';
            // dd($reques->all());
            $records = DownloadHistory::where('id', base64_decode($id))->first();
            $query = ProductHistory::with('lang');
            if (!empty($reques['shop'])) {
                $lang = $reques['language'];
                $shop = $reques['shop'];

                $query->whereHas('lang', function ($q) use ($lang,  $shop) {
                    $q->where('language', '=', $lang);
                    $q->where('shop_id', $shop);
                });
                // ->where('shop_id', $reques['shop'])
            } else {
                $query->where('download_histories_id', base64_decode($id));
            }

            $data  =    $query->get();
            // dd($data->toArray());

            $shops = EtsyConfig::where('id',  $records->shop_id)->get();


            if ($data) {
                return view('etsy.view_product_list', compact('data', 'records', 'url', 'shops'));
            }
            return redirect('etsy-list-data');
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }




    public function etsyListDataProgress(Request $request, $id = null)
    {
        $url = '';
        $page = 1;
        $limit = 100;
        $data = [];
        $etsy_id = '';



        if ($request->isMethod('post')) {
            $request->validate([
                'shop' => 'required',
            ]);

            $input_shop_id = $request['shop'];


            $sync_type = isset($request['sync_type']) ? $request['sync_type'] : 'Auto';
            $resultSetting = EtsySettings::first();
            $result = EtsyConfig::where('id', $request['shop'])->first();

            $language  =  isset($result['language']) ? $result['language'] : 'en';

            if ($result) {

                EtsyProduct::where('shop_id', $request['shop'])->delete();

                $key_string = $resultSetting['key_string'];
                $api_access_token = $resultSetting['api_access_token'];
                $shop_id = $result['shop_name'];
                $appurl = $resultSetting['app_url'];
                ////ddsdd

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $appurl . 'shops/' . $shop_id . '/listings/active?api_key=' . $key_string,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'x-api-key:' . $key_string,
                        'Authorization: Bearer ' . $api_access_token,
                        'Cookie: fve=1643640618.0; uaid=JYYRIuVpd8k7JhiFS1kUcXLRgoxjZACCxO_ftWB0tVJpYmaKkpWSU4VlREBwmXOBj19QsXNFgW9gvnliYURAQHlagFItAwA.; user_prefs=CFmwDxv3XIPcLuHsJleib85a6epjZACCxO_ftWB0tJKnX5CSTl5pTo6OUmqerruTkg5QCCpiBKFwEbEMAA..'
                    ),
                ));

                $response = curl_exec($curl);


                curl_close($curl);
                $totalProduct =  json_decode($response);

                return response()->json(['status' => 'success', 'data' =>  $totalProduct]);
            } else {
                return response()->json(['status' => 'error', 'data' =>  '']);
            }
        }

        // return view('etsy.product_list', compact('url', 'data', 'page', 'limit', 'shops', 'etsy_id'));
    }
}
