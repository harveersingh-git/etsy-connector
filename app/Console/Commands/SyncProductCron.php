<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\EtsyConfig;
use App\Models\EtsyProduct;
use App\Models\DownloadHistory;
use App\Models\EtsySettings;
use App\Models\ProductHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SyncProductCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncproduct:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        // if ($request->isMethod('post')) {
        $shops = EtsyConfig::where('status', '1')->get();

        $user = User::role('Admin')->first();
        if ($shops) {
            foreach ($shops as $shop) {
                // echo $shop->id."</br>";
                $input_shop_id = $shop->id;
                $language = $shop->language;
                $sync_type = 'Auto';
                $resultSetting = EtsySettings::first();
                $result = EtsyConfig::where('id', $input_shop_id)->first();
                if ($result) {

                    EtsyProduct::where('shop_id', $input_shop_id)->delete();

                    $key_string = $resultSetting['key_string'];
                    $api_access_token = $resultSetting['api_access_token'];
                    $shop_id = $result['shop_name'];
                    $appurl = $resultSetting['app_url'];
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
                            $new_response =  json_decode($response);
                            // _response ((int) $new_response->results);
                            if ((int) count($new_response->results) > 0) {

                                $product_data = array();

                                foreach ($new_response->results as $value) {

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
                                    $product_data["user_id"] = $user->id;
                                    $product_data["shop_id"] = $input_shop_id;
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
                            $this->exportMultiLangCsv($download_history_id->id, $sync_type);
                        }

                    }
                }
            }
        }
    }

    public function exportCsv($shop_name = null,  $language, $sync_type)
    {

        $total_language = [
            'de' => 'de_DE', 'en' => 'en_XX', 'es' => 'es_XX', 'fr' => 'fr_XX', 'it' => 'it_IT', 'ja' => 'ja_XX', 'nl' => 'nl_XX', 'pl' => 'pl_PL',
            'pt' => 'pt_XX', 'ru' => 'ru_RU'
        ];
        $url = '';
        $date = Carbon::now()->toDateString();

        $rand = rand(100, 999);
        $click =  EtsyProduct::where('shop_id', $shop_name)->get();
        $get_name = EtsyConfig::find($shop_name);
        $user = User::role('Admin')->first();
        if (count($click) > 0) {

            $columns = ['id', 'override', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];

            $fileName = $get_name->shop_name . '-' . $shop_name . '.csv';
            $tasks = $click;
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );


            $file = fopen("public/uploads/" . $fileName, 'w');
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


                fputcsv($file, $row);
            }
            fclose($file);
            $array = [
                'user_id' =>    $user->id,
                'file_name' => $fileName,
                'date' =>  $date,
                'shop_id' => $shop_name,
                'language' =>  $language,
                'sync_type' => $sync_type

            ];
            $data =   DownloadHistory::create($array);

            return $data;
        }
    }



    public function exportMultiLangCsv($download_histories_id, $sync_type)
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
            $dhistory = DownloadHistory::with('shops')->find($download_histories_id);

            $columns = ['id', 'override', 'title', 'description', 'price', 'condition', 'availability', 'brand', 'link', 'image_link'];

            // $fileName = $date . '-' . $t . 'productlist.csv';
            $fileName = 'multi' . $dhistory['shops']->shop_name . '-' . $dhistory->shop_id .  '.csv';


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
            foreach ($total_language  as $key => $language_owerWrite) {
                $key_lan[] = $key;
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

            $multi_array = [
                'parent_id' => $dhistory->id,
                'user_id' => $dhistory->user_id,
                // 'file_name' => $fileName,
                'multi_lang_file_name' => $fileName,
                'date' => $dhistory->date,
                'shop_id' => $dhistory->shop_id,
                'language' =>  implode(",", $key_lan),
                'sync_type' => $dhistory->sync_type

            ];
            DownloadHistory::create($multi_array);
            // $dhistory->update(['multi_lang_file_name' =>   $fileName]);
            return true;
        }
    }

    public function productListImage($list_id)
    {

        // $list_id = "1197687199";

        // $data =  EtsyProduct::get();
        // if ($request->isMethod('post')) {
        $user = User::role('Admin')->first();

        $id = $user->id;
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
}
