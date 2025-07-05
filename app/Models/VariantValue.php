<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantValue extends Model
{
    protected $fillable = [
        'variant_id',
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
