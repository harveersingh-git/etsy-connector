<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Auth;
use Gate;
use App\Models\Country;


class GetCountry
{
    public static function getCountryCode()
    {

        $country =  Country::orderBy('name', 'ASC')->get();

        return $country;
    }
}
