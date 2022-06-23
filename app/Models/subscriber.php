<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class subscriber extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="subscribers";
    protected $fillable = [
        'user_id', 'city','state','zip','auto_email_update','country_id','address'
    ];
}
