<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'file_name', 'user_id', 'shop_id', 'language','sync_type'
    ];
    public function shops()
    {
        return $this->hasOne(EtsyConfig::class, 'id', 'shop_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
