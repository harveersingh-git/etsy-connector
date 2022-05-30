<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EtsyConfig;
use App\Models\EtsyProduct;
use App\Models\DownloadHistory;
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
        // dd($request->all());
        // $id = Auth::user()->id;
        $id = $request['id'];

        $result = EtsyConfig::where('id', $id)->first();

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
                $user = EtsyConfig::where('user_id', $id)->first();
                $array = [
                    'access_token_secret' => isset($oauth_token_secret) ? ($oauth_token_secret) : '',
                    'access_token' => isset($oauth_token) ? ($oauth_token) : '',
                ];

                $user->update($array);

                return response()->json(['status' => 'success', 'data' =>  $auth_url]);
            }
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
            $result = EtsyConfig::where('id', $id)->first();

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
        $result = EtsyConfig::where('user_id', $id)->first();
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

    // public function countryList()
    // {
    //     $result =  $this->getRequestAuthorization()->findAllCountry();
    //     dd($result);
    // }


    /**
     * 
     * get the product list form the etsy
     *
     * @return void
     */
    public function etsyListData(Request $request)
    {
        $url = '';
        $page = 1;
        $limit = 100;

        $roles = Auth::user()->getRoleNames();

        if ($roles[0] == 'Admin') {
            $shops = EtsyConfig::get();
            $data =  EtsyProduct::get();
        } else {

            $shops = EtsyConfig::where('user_id', auth()->user()->id)->get();
            $shops_ids = $shops->pluck('id');
            $data =  EtsyProduct::with('shops')->whereIn('shop_id', $shops_ids)->get();
        }



        if ($request->isMethod('post')) {
            $request->validate([
                'shop' => 'required',
            ]);

            $result = EtsyConfig::where('id', $request['shop'])->first();

            if ($result) {

                EtsyProduct::where('shop_id', $request['shop'])->delete();

                $key_string = $result['key_string'];
                $api_access_token = $result['api_access_token'];
                $shop_id = $result['shop_name'];
                $appurl = $result['app_url'];
                ////
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

                if ($totalProduct) {
                    $limit = 100;
                    if ($totalProduct->count > 100) {
                        $total_page = intval(round($totalProduct->count / $limit));
                    } else {
                        $total_page = $totalProduct->count;
                    }



                    ////
                    for ($i = 1; $i <= $total_page; $i++) {
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $appurl . 'shops/' . $shop_id . '/listings/active?api_key=' . $key_string . '&page=' . $i . '&limit=' . $limit,
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

                                $product_data["date"] = Carbon::now()->toDateString();;
                                ProductHistory::create($product_data);
                            }
                        }
                    }
                    return redirect()->back()->with("success", "Product Sync successfully!");
                }
                return redirect()->back()->with("success", "No product found for the given shop !");
            } else {
                return redirect()->back()->with("success", "Please check ETSY configration!");
            }
        }

        return view('etsy.product_list', compact('url', 'data', 'page', 'limit', 'shops'));
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

        // $list_id = "602091044";
        $url = '';
        $data =  EtsyProduct::get();
        // if ($request->isMethod('post')) {
        $id = Auth::user()->id;
        $result = EtsyConfig::where('user_id', $id)->first();
        if ($result) {
            $appurl = $result['app_url'];
            $key_string = $result['key_string'];
            $api_access_token = $result['api_access_token'];


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
    public function exportCsv(Request $request)
    {

        $url = '';
        $roles = Auth::user()->getRoleNames();
        if ($roles[0] == 'Admin') {
            $shops = EtsyConfig::get();
        } else {
            $shops = EtsyConfig::where('user_id', auth()->user()->id)->get();
        }
        if ($request->isMethod('post')) {

            $date = Carbon::now()->toDateString();
            $click =  EtsyProduct::where('shop_id', $request['shop_name'])->get();

            if (count($click) > 0) {

                $columns = ['id', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];

                $fileName = $date . '-' . auth()->user()->id . '-' . $request['shop_name'] . '-' . 'productlist.csv';
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
                    $file_current = fopen('php://output', 'w');
                    $file = fopen("public/uploads/" . $fileName, 'w');

                    fputcsv($file_current, $columns);
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

                        fputcsv($file_current, $row);
                        fputcsv($file, $row);
                    }

                    // file_put_contents("public/", $fileName);
                    fclose($file_current);
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
            } else {
                return redirect()->back()->with("success", "No product found for the given shop !");
            }
        }
        return view('etsy.csv', compact('url', 'shops'));
    }
}
