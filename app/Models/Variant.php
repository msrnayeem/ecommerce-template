<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function variantValues()
    {
        return $this->hasMany(VariantValue::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
