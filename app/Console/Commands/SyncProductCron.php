<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\EtsyConfig;
use App\Models\EtsyProduct;
use App\Models\DownloadHistory;
use App\Models\EtsySettings;
use App\Models\ProductHistory;
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
        if ($request->isMethod('post')) {
            
            $input_shop_id = $request['shop'];
            $language = isset($request['language']) ? $request['language'] : 'en';
            $sync_type ='Auto';
            $resultSetting = EtsySettings::first();
            $result = EtsyConfig::where('id', $request['shop'])->first();
            // dd($resultSetting->toArray());
            if ($result) {

                EtsyProduct::where('shop_id', $request['shop'])->delete();

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
                    }
                    return response()->json(['status' => 'success', 'data' =>  $totalProduct]);
                    // return redirect()->back()->with("success", "Product Sync successfully!");
                }
                return redirect()->back()->with("success", "No product found for the given shop !");
            } else {
                return redirect()->back()->with("success", "Please check ETSY configration!");
            }
        }

        dd('success');
    }
}
