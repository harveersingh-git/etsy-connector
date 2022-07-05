<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Auth;
use Gate;
use App\Models\Localization;


class Language
{
    public static function getLanguage()
    {
        $language1[] =  [
            "name" => "en",
            "value" => "English"
        ];

        $language =  Localization::select('name', 'value','country_flag')->orderBy('name', 'ASC')->get();

        // $language =  array_merge($language1, $language2);
    
        return $language;
    }
}
