<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function orderSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|numeric|digits:11',
            'inset_address' => 'required|string|max:500',
            'deliveryTitle' => 'required|in:1,2',
            'payment_method' => 'required|in:Cash On Delivery,Bkash',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customerInfo = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('inset_address'),
            'delivery_title' => $request->input('deliveryTitle'),
            'payment_method' => $request->input('payment_method'),
        ];

        $deliveryCharge = $customerInfo['delivery_title'] == '1' ? 60 : 120;

        $cartItems = $request->input('items');
        $orderItems = [];
        $productPrice = 0;

        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item['product_id']);
            $variant = $item['variant_id'] ? ProductVariant::where('id', $item['variant_id'])->where('product_id', $product->id)->first() : null;

            // Use product price if variant price is 0 or null
            $price = $variant && ($variant->discount_price ?? $variant->price) > 0
                ? ($variant->discount_price ?? $variant->price)
                : ($product->discount_price ?? $product->price);
            $subtotal = $price * $item['quantity'];
            $productPrice += $subtotal;

            $orderItems[] = [
                'orderable_type' => $variant && ($variant->discount_price ?? $variant->price) > 0 ? ProductVariant::class : Product::class,
                'orderable_id' => $variant && ($variant->discount_price ?? $variant->price) > 0 ? $variant->id : $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'unit_price' => $price,
                'quantity' => $item['quantity'],
                'total' => $subtotal,
            ];
        }

        $totalAmount = $productPrice + $deliveryCharge;

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $customerInfo['name'],
            'customer_phone' => $customerInfo['phone'],
            'shipping_address' => $customerInfo['address'],
            'shipping_method' => $customerInfo['delivery_title'] == '1' ? 'Inside Dhaka' : 'Outside Dhaka',
            'delivery_charge' => $deliveryCharge,
            'total_amount' => $totalAmount,
            'payment_method' => $customerInfo['payment_method'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'orderable_type' => $item['orderable_type'],
                'orderable_id' => $item['orderable_id'],
                'name' => $item['name'],
                'sku' => $item['sku'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);
        }

        session()->forget('selected_products');
        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue('cart', json_encode([]), 43200);

        return redirect()->route('order.success', ['order_id' => $order->id])
            ->with('success', 'Order placed successfully! Your order ID is '.$order->id);
    }

    public function success($order_id)
    {
        $order = Order::with(['orderItems.orderable'])->findOrFail($order_id);

        $order->orderItems->loadMorph('orderable', [
            \App\Models\Product::class => ['productImages'],
            \App\Models\ProductVariant::class => ['productImages', 'product.productImages', 'variant', 'variantValue'],
        ]);

        return view('pages.success', compact('order'));
    }

    public function invoice(Request $request, $order_id)
    {
        $order = Order::with(['orderItems.orderable'])->findOrFail($order_id);

        // Dynamically load morph relations based on actual type
        $order->orderItems->loadMorph('orderable', [
            \App\Models\Product::class => ['productImages'],
            \App\Models\ProductVariant::class => ['productImages', 'product.productImages', 'variant', 'variantValue'],
        ]);

        return view('pages.invoice', compact('order'));
    }
}
