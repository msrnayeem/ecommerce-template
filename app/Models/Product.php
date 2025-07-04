<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'sku',
        'name',
        'description',
        'price',
        'discount_price',
        'category_id',
        'warranty',
        'visibility',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // FIXED: Return all images (product + variant)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->whereNull('variant_id');
    }

    public function variantImages()
    {
        return $this->hasMany(ProductImage::class)->whereNotNull('variant_id');
    }

    public function allImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_products')
            ->withPivot('variant_id', 'offer_price')
            ->withTimestamps();
    }
}