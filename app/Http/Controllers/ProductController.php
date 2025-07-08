<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function buyNow($sku, $variant = null)
{
    $product = Product::with('productVariants.variantValue', 'productImages')->where('sku', $sku)->firstOrFail();
    $variant_info = $variant ? $product->productVariants->firstWhere('id', $variant) : null;

    // Use product price if variant price is 0 or null
    $price = $variant_info && ($variant_info->discount_price ?? $variant_info->price) > 0 
        ? ($variant_info->discount_price ?? $variant_info->price) 
        : ($product->discount_price ?? $product->price);
    $original_price = $variant_info && ($variant_info->discount_price ?? $variant_info->price) > 0 
        ? $variant_info->price 
        : ($product->discount_price ? $product->price : null);

    $cart = [
        [
            'product_id' => $product->id,
            'variant_id' => $variant_info?->id,
            'quantity' => 1,
            'name' => $product->name,
            'sku' => $product->sku,
            'image' => $product->productImages->first()?->path ?? 'https://via.placeholder.com/150',
            'price' => $price,
            'original_price' => $original_price,
            'variant_name' => $variant_info?->variantValue?->name,
            'variant_value_id' => $variant_info?->variantValue?->id,
        ],
    ];

    $total = $price * $cart[0]['quantity'];

    return view('pages.buy-now', compact('product', 'cart', 'total'));
}
  

    public function show($sku)
    {
        $product = Product::where('sku', $sku)
            ->with(['productImages', 'productVariants.variantValue'])
            ->firstOrFail();
        // dd($product);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['productImages' => function ($query) {
                $query->where('is_primary', true);
            }])
            ->take(4)
            ->get();

        // dd($product);
        return view('pages.product-details', compact('product', 'relatedProducts'));
    }

}
