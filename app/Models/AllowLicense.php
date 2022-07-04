<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowLicense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'expire_date'
    ];
}
