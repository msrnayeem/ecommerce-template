<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'product_id',
        'image_path',
        'alt_text',
        'is_primary',
        'order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}