<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\DeliveryCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function add(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $product = Product::with(['productImages', 'productVariants'])->findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::with('variant', 'variantValue')->findOrFail($request->variant_id) : null;
        // dd($variant);
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $cartKey = $variant ? $product->id.'_'.$variant->id : $product->id;

        // Use product price if variant price is 0 or null
        $price = $variant && ($variant->discount_price ?? $variant->price) > 0
            ? ($variant->discount_price ?? $variant->price)
            : ($product->discount_price ?? $product->price);
        $original_price = $variant && ($variant->discount_price ?? $variant->price) > 0
            ? $variant->price
            : $product->price;

        $cartItem = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $price,
            'original_price' => $original_price,
            'image' => $product->productImages->first()?->path ?? 'https://via.placeholder.com/150',
            'quantity' => $request->quantity,
            'variant_id' => $variant?->id,
            'variant_name' => $variant?->variant?->name,
            'variant_value' => $variant?->variantValue?->name,
        ];
        // dd($cartItem);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = $cartItem;
        }

        Cookie::queue('cart', json_encode($cart), 43200);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'change' => 'required|integer',
        ]);

        $cart = json_decode(Cookie::get('cart', '[]'), true);

        if (isset($cart[$request->cart_key])) {
            $newQuantity = $cart[$request->cart_key]['quantity'] + $request->change;
            if ($newQuantity < 1) {
                unset($cart[$request->cart_key]);
            } else {
                $cart[$request->cart_key]['quantity'] = $newQuantity;
            }
            Cookie::queue('cart', json_encode($cart), 43200);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Item not found in cart'], 400);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        \Log::info('Remove request received', [
            'cart_key' => $request->cart_key,
            'cart_state_before' => json_decode(Cookie::get('cart', '[]'), true),
        ]);

        $cart = json_decode(Cookie::get('cart', '[]'), true);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            Cookie::queue('cart', json_encode($cart), 43200);
            \Log::info('Item removed from cart', [
                'cart_key' => $request->cart_key,
                'cart_state_after' => $cart,
            ]);

            return redirect()->back()->with('success', 'Item removed from cart!');
        }

        \Log::warning('Item not found in cart', [
            'cart_key' => $request->cart_key,
            'cart_state' => $cart,
        ]);

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function cart()
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $validCart = [];
        $total = 0;
        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['id']);
            $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;
            if ($product && ! $product->trashed() && (! $item['variant_id'] || ($variant && $variant->product_id === $product->id))) {
                $validCart[$cartKey] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        if ($cart !== $validCart) {
            Cookie::queue('cart', json_encode($validCart), 43200);
        }

        // Debug: Log cart data to verify
        \Log::info('Cart dataa:', $validCart);

        return view('pages.cart', ['cart' => $validCart, 'total' => $total]);
    }

    public function index(Request $request)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $selectedProducts = $request->query('selected_products', []);

        if (! is_array($selectedProducts)) {
            $selectedProducts = [$selectedProducts];
        }

        $selectedCart = [];
        $total = 0;
        foreach ($cart as $cartKey => $item) {
            $product = Product::find($item['id']);
            $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;
            if ($product && ! $product->trashed() && (! $item['variant_id'] || ($variant && $variant->product_id === $product->id)) && in_array($cartKey, $selectedProducts)) {
                $selectedCart[$cartKey] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        if (empty($selectedCart)) {
            return redirect()->route('cart.cart')->with('error', 'Please select at least one item to proceed to checkout.');
        }

        session(['selected_products' => $selectedProducts]);

        $charges = DeliveryCharge::where('status',true)->get();

        return view('pages.checkout', ['cart' => $selectedCart, 'total' => $total,'charges'=>$charges]);
    }
}
