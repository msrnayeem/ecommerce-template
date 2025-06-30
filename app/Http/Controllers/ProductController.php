<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function buyNow($sku)
    {
        $product = Product::with('variants', 'images')->where('sku', $sku)->firstOrFail();
        $cart = [
            [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->images->first()?->image_path ?? 'https://via.placeholder.com/150',
                'price' => $product->discount_price ?? $product->price,
                'original_price' => $product->discount_price ? $product->price : null,
                'quantity' => 1,
            ],
        ];

        $total = $cart[0]['price'];

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
            ->with(['images', 'variants']) // Make sure to eager load variants too
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => function ($query) {
                $query->where('is_primary', true);
            }])
            ->take(4)
            ->get();
//dd($product);
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
