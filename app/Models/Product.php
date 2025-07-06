<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'warranty',
        'visibility',
        'is_featured',
        'has_variant',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'visibility' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function hasVariants()
    {
        return $this->has_variant || $this->productVariants()->exists();
    }

    public function productImages()
    {
        return $this->morphMany(ProductImage::class, 'imageable');
    }

    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    // Check if product uses variant-specific pricing/stock
    public function hasVariantPricing()
    {
        return $this->productVariants()->whereNotNull('price')->orWhereNotNull('stock')->exists();
    }

    // Get price (from product variants or product table)
    public function getEffectivePrice($variantValueIds = [])
    {
        if ($this->hasVariantPricing() && ! empty($variantValueIds)) {
            $variant = $this->productVariants()
                ->whereIn('variant_value_id', $variantValueIds)
                ->first();

            return $variant->price ?? $this->price;
        }

        return $this->price;
    }

    // Get stock (from product variants or product table)
    public function getEffectiveStock($variantValueIds = [])
    {
        if ($this->hasVariantPricing() && ! empty($variantValueIds)) {
            $variant = $this->productVariants()
                ->whereIn('variant_value_id', $variantValueIds)
                ->first();

            return $variant->stock ?? $this->stock;
        }

        return $this->stock;
    }

    // Scope to get low stock products
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where(function ($q) use ($threshold) {
            // Case 1: Stock in products table
            $q->whereNotNull('stock')
                ->where('stock', '<=', $threshold)
                ->whereDoesntHave('productVariants', function ($subQuery) {
                    $subQuery->whereNotNull('stock');
                })
                ->orWhereHas('productVariants', function ($subQuery) use ($threshold) {
                    // Case 2: Stock in product_variants table
                    $subQuery->whereNotNull('stock')
                        ->where('stock', '<=', $threshold);
                });
        })->with(['productVariants.variant', 'productVariants.variantValue', 'productImages']);
    }
}
