<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtsySettings extends Model
{
    use HasFactory;
    protected $fillable = [
     
        'app_url',
        'key_string',
        'shared_secret',
        'access_token_secret',
        'access_token',
        // 'shop_name',
        // 'user_name',
        // 'country_id',
        // 'store_id',
        'api_access_token',
        'api_access_secret',
        'status'
        // 'status',
        // 'language'
    ]; 
}