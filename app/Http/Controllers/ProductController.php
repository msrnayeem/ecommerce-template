<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function buyNow($sku, $variant = null)
{
    $product = Product::with('productVariants.variantValue', 'productImages')->where('sku', $sku)->firstOrFail();
    $variant_info = $variant ? $product->productVariants->firstWhere('id', $variant) : null;

    $price = $variant_info ? ($variant_info->discount_price ?? $variant_info->price) : ($product->discount_price ?? $product->price);

    $cart = [
        [
            'product_id' => $product->id,
            'variant_id' => $variant_info?->id,
            'quantity' => 1,
            'name' => $product->name,
            'sku' => $product->sku,
            'image' => $product->productImages->first()?->path ?? 'https://via.placeholder.com/150',
            'price' => $price,
            'original_price' => $variant_info ? $variant_info->price : ($product->discount_price ? $product->price : null),
            'variant_name' => $variant_info?->variantValue?->name,
            'variant_value_id' => $variant_info?->variantValue?->id,
        ]
    ];

    $total = $price * $cart[0]['quantity'];

    return view('pages.buy-now', compact('product', 'cart', 'total'));
}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
