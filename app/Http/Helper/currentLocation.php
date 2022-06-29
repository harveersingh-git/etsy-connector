<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Auth;
use Gate;
use App\Models\Localization;


class CurrentLocation
{
    public static function getLocation()
    {

        $publicIp = Self::get_client_ip();
  
        if ($publicIp == "::1") {
            $publicIp = '103.42.91.34';
        }

        $currentLocation = \Location::get($publicIp);
  
        // dd($currentLocation);

        return $currentLocation;
    }


    public  static function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
