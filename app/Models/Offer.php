<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Offer extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products')
            ->withPivot('product_variant_id', 'offer_price')
            ->withTimestamps();
    }

    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'offer_products', 'offer_id', 'product_variant_id')
            ->withPivot('offer_price')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function getIsCurrentlyActiveAttribute()
    {
        return $this->is_active &&
               $this->start_date <= now() &&
               ($this->end_date === null || $this->end_date >= now());
    }
}
