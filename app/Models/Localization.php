<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use File;

class Localization extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'name', 'value', 'file', 'created_at', 'updated_at'];

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
