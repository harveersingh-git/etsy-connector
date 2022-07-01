<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Auth;
use Gate;


class CheckPermission
{
    public static function checkPermission()
    {
        // $allowPermission = auth()->user()->getAllPermissions()->pluck('name')->toArray();



        if (auth()->user()->roles->pluck('name')[0] != "admin") {

            if (auth()->user()->license == '0') {

                // $this->authorize($permission);
                $data= '0';
                return $data;
                // abort_if(Gate::denies('denied'), code: 403);
            
            }
        }
        return true;
    }
}
