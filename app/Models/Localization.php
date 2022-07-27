<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localization extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'user_id', 'name', 'value', 'file', 'country_flag', 'created_at', 'updated_at'];

    public function destory($id)
    {
        $data =  Self::find($id);
        $success = $data->delete();

        return $success;
    }


    // public function create($input, $imageName = null)
    // {

    //     $array = [
    //         'user_id' => auth()->user()->id,
    //         'name' => isset($input['name']) ? ($input['name']) : '',
    //         'value' => isset($input['value']) ? ($input['value']) : '',
    //         'file' => isset($input['file']) ? ($imageName) : '',
    //     ];

    //     return $data = Self::create($array);
    // }
}
