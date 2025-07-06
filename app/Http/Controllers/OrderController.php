<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function orderSubmit(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|numeric|digits:11',
            'inset_address' => 'required|string|max:500',
            'deliveryTitle' => 'required|in:1,2',
            'payment_method' => 'required|in:Cash On Delivery,Bkash',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.product_id' => 'required|uuid|exists:products,id',
            'items.*.variant_id' => 'nullable|uuid|exists:product_variants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Extract customer information
        $customerInfo = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('inset_address'),
            'delivery_title' => $request->input('deliveryTitle'),
            'payment_method' => $request->input('payment_method'),
        ];

        // Extract delivery charge based on deliveryTitle
        $deliveryCharge = $customerInfo['delivery_title'] == '1' ? 60 : 120;

        // Extract cart items
        $cartItems = $request->input('items');

        // Process cart items
        $orderItems = [];
        $productPrice = 0;

        foreach ($cartItems as $itemId => $item) {
            // Fetch variant details (if variant_id exists)
            $variant = $item['variant_id'] ? ProductVariant::where('id', $item['variant_id'])
                ->where('product_id', $item['product_id'])
                ->first() : null;

            // Determine price (prefer discount_price if available, otherwise use price)
            $price = $variant ? ($variant->discount_price ?? $variant->price) : 0;

            if ($price > 0) {
                $subtotal = $price * $item['quantity'];
                $productPrice += $subtotal;

                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'name' => $variant ? $variant->variant_name : 'Unknown Product', // Adjust based on product name source
                    'variant_name' => $variant ? $variant->variant_name : null,
                    'variant_value' => $variant ? $variant->variant_value : null,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $subtotal,
                ];
            } else {
                // Handle case where variant or price is not found
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid product or variant price for item ID: '.$itemId);
            }
        }

        // Calculate total amount (product price + delivery charge)
        $totalAmount = $productPrice + $deliveryCharge;

        // Create order in the database
        $order = Order::create([
            'id' => Str::uuid(),
            'customer_name' => $customerInfo['name'],
            'customer_phone' => $customerInfo['phone'],
            'customer_email' => null, // Not provided in form
            'shipping_address' => $customerInfo['address'],
            'shipping_method' => $customerInfo['delivery_title'] == '1' ? 'Inside Dhaka' : 'Outside Dhaka',
            'order_notes' => null, // Not provided in form
            'coupon' => null, // Not provided in form
            'shipping_status' => 'pending',
            'status' => 'pending',
            'delivery_charge' => $deliveryCharge,
            'product_price' => $productPrice,
            'total_amount' => $totalAmount,
            'payment_method' => $customerInfo['payment_method'],
            'payment_id' => null, // Not provided in form
            'payment_status' => 'unpaid',
        ]);

        // Attach items to the order
        foreach ($orderItems as $item) {
            OrderItem::create([
                'id' => Str::uuid(),
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'name' => $item['name'],
                'sku' => null, // Not provided in form
                'variant_name' => $item['variant_name'],
                'variant_value' => $item['variant_value'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);
        }

        // Clear session
        session()->forget('selected_products');
        Cookie::queue(Cookie::forget('cart'));
        // Clear cart cookie
        Cookie::queue('cart', json_encode([]), 43200); // Clear cart cookie

        // Redirect to checkout with order details
        return redirect()->route('order.success', ['order_id' => $order->id])
            ->with('success', 'Order placed successfully! Your order ID is '.$order->id);
    }

    public function success($order_id)
    {
        $order = Order::with('orderItems')->findOrFail($order_id);

        return view('pages.success', compact('order'));
    }

    public function invoice(Request $request, $order_id)
    {
        $order = Order::with('items')->findOrFail($order_id);

        return view('pages.invoice', compact('order'));
    }
}
