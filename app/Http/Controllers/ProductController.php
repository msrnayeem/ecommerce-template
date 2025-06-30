<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{

public function orderNow(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'phone' => 'required|string|max:20',
        'inset_address' => 'required|string|max:500',
        'deliveryTitle' => 'required|in:1,2',
        'quantity' => 'required|integer|min:1',
        'sku' => 'required|string|max:50',
        'variant_id' => 'nullable|uuid|exists:product_variants,id',
        'payment_method' => 'required|in:Cash On Delivery,Bkash',
    ]);

    // Calculate delivery charge
    $deliveryCharge = $validated['deliveryTitle'] == '1' ? 60 : 120;

    // Fetch product details
    $product = Product::with('variants')->where('sku', $validated['sku'])->firstOrFail();
    $variant_info = $validated['variant_id'] ? $product->variants->firstWhere('id', $validated['variant_id']) : null;

    // Calculate price
    $unitPrice = $variant_info ? ($variant_info->discount_price ?? $variant_info->price) : ($product->discount_price ?? $product->price);
    $subtotal = $unitPrice * $validated['quantity'];
    $total = $subtotal + $deliveryCharge;

    // Create order
    $order = Order::create([
        'id' => (string) Str::uuid(),
        'user_id' => auth()->id() ?? null,
        'customer_name' => $validated['name'],
        'customer_phone' => $validated['phone'],
        'shipping_address' => $validated['inset_address'],
        'shipping_method' => $validated['deliveryTitle'] == '1' ? 'Inside Dhaka' : 'Outside Dhaka',
        'delivery_charge' => $deliveryCharge,
        'total_amount' => $total,
        'payment_method' => $validated['payment_method'],
        'payment_status' => $validated['payment_method'] == 'Cash On Delivery' ? 'unpaid' : 'pending',
        'status' => 'pending',
        'shipping_status' => 'pending',
    ]);

    // Create order item
    OrderItem::create([
        'id' => (string) Str::uuid(),
        'order_id' => $order->id,
        'product_id' => $product->id,
        'variant_id' => $validated['variant_id'],
        'name' => $product->name,
        'sku' => $validated['sku'],
        'variant_name' => $variant_info?->variant_name,
        'variant_value' => $variant_info?->variant_value,
        'price' => $unitPrice,
        'quantity' => $validated['quantity'],
        'total' => $subtotal,
    ]);

    return redirect()->route('order.success', ['order_id' => $order->id])
        ->with('success', 'Order placed successfully! Your order ID is ' . $order->id);
}

public function buyNow($sku, $variant = null)
{
    $product = Product::with('variants', 'images')->where('sku', $sku)->firstOrFail();

    $variant_info = $variant ? $product->variants->firstWhere('id', $variant) : null;

    $cart = [
        [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'image' => $product->images->first()?->image_path ?? 'https://via.placeholder.com/150',
            'price' => $variant_info ? ($variant_info->discount_price ?? $variant_info->price) : ($product->discount_price ?? $product->price),
            'original_price' => $variant_info ? $variant_info->price : ($product->discount_price ? $product->price : null),
            'quantity' => 1,
            'variant_id' => $variant_info?->id,
            'variant_name' => $variant_info?->variant_name,
            'variant_value' => $variant_info?->variant_value,
        ],
    ];

    $total = $cart[0]['price'] * $cart[0]['quantity'];

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
