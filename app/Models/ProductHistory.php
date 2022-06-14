<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'title',
        'description',
        'price',
        'materials',
        'shipping_template_id',
        'taxonomy_id',
        'shop_section_id',
        'image_ids',
        'store_id',
        'is_customizable',
        'non_taxable',
        'image',
        'state',
        'processing_min',
        'processing_max',
        'non_taxable',
        'tags',
        'who_made',
        'is_supply',
        'when_made',
        'style',
        'listing_id',
        'url',
        'currency_code',
        'availability',
        'brand',
        'condition',
        'image_url',
        'user_id',
        'date',
        'shop_id',
        'download_histories_id'

    ];
    public function shops()
    {
        return $this->hasOne(EtsyConfig::class, 'id', 'shop_id');
    }

    public function lang()
    {
        return $this->belongsTo(DownloadHistory::class, 'download_histories_id', 'id');
    }
}
