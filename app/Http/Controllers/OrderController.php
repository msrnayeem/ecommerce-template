<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:11',
            'inset_address' => 'required|string|max:500',
            'deliveryTitle' => 'required|in:1,2',
            'payment_method' => 'required|in:Cash On Delivery,Bkash',
        ]);

        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $selectedProducts = session('selected_products', []);

        if (empty($cart) || empty($selectedProducts)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty or no items selected.');
        }

        // Filter cart to include only selected items
        $selectedCart = [];
        $total = 0;
        foreach ($cart as $cartKey => $item) {
            if (in_array($cartKey, $selectedProducts)) {
                $selectedCart[$cartKey] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        if (empty($selectedCart)) {
            return redirect()->route('cart.index')->with('error', 'No valid items selected.');
        }

        // Create Order
        $order = Order::create([
            'id' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'shipping_address' => $request->inset_address,
            'shipping_method' => $request->deliveryTitle == '1' ? 'Inside Dhaka' : 'Outside Dhaka',
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'Cash On Delivery' ? 'unpaid' : 'pending',
            'status' => 'pending',
            'shipping_status' => 'pending',
        ]);

        // Create Order Items
        foreach ($selectedCart as $cartKey => $item) {
            OrderItem::create([
                'id' => (string) Str::uuid(),
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'variant_id' => $item['variant_id'],
                'name' => $item['name'] . ($item['variant_id'] ? ' (' . $item['variant_name'] . ': ' . $item['variant_value'] . ')' : ''),
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Remove selected items from cart
        foreach ($selectedProducts as $cartKey) {
            unset($cart[$cartKey]);
        }
        Cookie::queue('cart', json_encode($cart), 43200);

        // Clear session
        session()->forget('selected_products');

        // Redirect to checkout with order details
        return redirect()->route('order.success', ['order_id' => $order->id])
            ->with('success', 'Order placed successfully! Your order ID is ' . $order->id);
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