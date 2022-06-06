<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EtsyConfig;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role =  Auth::user()->roles->pluck('name')[0];
        if ($role == 'Admin') {
            $data['total_users'] = User::count();
            $data['active_users'] = User::where('active', '1')->count();
            $data['total_shops'] = EtsyConfig::count();
            $data['total_active_shop'] = EtsyConfig::where('status', '1')->count();


            return view('home', compact('data'));
        } else {
            return view('subscriber_home');
        }
    }

    public function overview()
    {
        $role =  Auth::user()->roles->pluck('name')[0];
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        $days_curent_month = array();
        // for ($d = 1; $d <= 31; $d++) {
        //     $time = mktime(12, 0, 0, date('m'), $d, date('Y'));
        //     if (date('m', $time) == date('m'))
        //         $days_curent_month[] = date('d', $time);
        // }
        for ($i = 1; $i <=  date('t'); $i++) {
            // add the date to the dates array
            $days_curent_month[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        // show the dates array


        if ($role == 'Admin') {
            $usermcount = [];
            $shopmcount = [];
            $days_usermcount = [];
            $days_shopmcount = [];

            $users = User::select('id', 'created_at')
                ->get()
                ->groupBy(function ($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                });
            $shops = EtsyConfig::select('id', 'created_at')
                ->get()
                ->groupBy(function ($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                });

            foreach ($users as $key => $value) {

                // $monthh[$key] =  date('F', mktime(0, 0, 0, $key, 1, date('Y')));
                $usermcount[(int)$key] = count($value);
            }
            foreach ($shops as $key => $val) {
                $shopmcount[(int)$key] = count($val);
            }
            foreach ($months as $key => $month) {
                $data['users'][] = isset($usermcount[$key]) ? $usermcount[$key] : 0;
                $data['shops'][] = isset($shopmcount[$key]) ? $shopmcount[$key] : 0;
            }
            array_unshift($data['users'], 'data1');
            array_unshift($data['shops'], 'data2');


            $days_users = User::select('id', 'created_at')
                ->get()
                ->groupBy(function ($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('d'); // grouping by months
                });

            foreach ($days_users as $key => $value) {

                // $monthh[$key] =  date('F', mktime(0, 0, 0, $key, 1, date('Y')));
                $days_usermcount[(int)$key] = count($value);
            }


            $days_shops = EtsyConfig::select('id', 'created_at')
                ->get()
                ->groupBy(function ($date) {
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                });
            foreach ($days_shops as $key => $val) {
                $days_shopmcount[(int)$key] = count($val);
            }
            foreach ($days_curent_month as $key => $month) {
                $data['days_users'][] = isset($days_usermcount[$key]) ? $days_usermcount[$key] : 0;
                $data['days_shops'][] = isset($days_shopmcount[$key]) ? $days_shopmcount[$key] : 0;
            }
            array_unshift($data['days_users'], 'data1');
            array_unshift($data['days_shops'], 'data2');
            $data['current_month_days'] = $days_curent_month;

            return response()->json(['status' => 'success', 'data' => $data]);
        } else {
            return response()->json(['status' => 'success']);
        }
    }



    function changeLang($langcode)
    {

  
        App::setLocale($langcode);
        session()->put("lang_code", $langcode);
        return redirect()->back();
    }
}
