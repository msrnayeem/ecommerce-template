<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'redirect_to_checkout' => 'nullable|boolean',
        ]);

        $product = Product::with(['images' => function ($query) {
            $query->where('is_primary', true)->first();
        }])->findOrFail($request->product_id);

        // Get cart from cookie
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        // If product is already in cart, update quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->discount_price ?? $product->price,
                'original_price' => $product->price,
                'image' => $product->images->first() ? $product->images->first()->image_path : 'https://via.placeholder.com/150',
                'quantity' => $request->quantity,
            ];
        }

        // Save cart to cookie (expires in 30 days)
        Cookie::queue('cart', json_encode($cart), 43200);

        if ($request->input('redirect_to_checkout', false)) {
            // Pass the added product ID as a query parameter
            return redirect()->route('cart.index', ['selected_products' => [$product->id]])->with('success', 'Product added to cart. Proceed to checkout.');
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'change' => 'required|integer',
        ]);

        $cart = json_decode(Cookie::get('cart', '[]'), true);

        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id]['quantity'] + $request->change;
            if ($newQuantity < 1) {
                unset($cart[$request->product_id]);
            } else {
                $cart[$request->product_id]['quantity'] = $newQuantity;
            }
            Cookie::queue('cart', json_encode($cart), 43200);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Product not found in cart'], 400);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = json_decode(Cookie::get('cart', '[]'), true);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Cookie::queue('cart', json_encode($cart), 43200);
            return redirect()->back()->with('success', 'Product removed from cart!');
        }

        return redirect()->back()->with('error', 'Product not found in cart.');
    }

    public function cart()
    {
        // Get cart from cookie
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        // Verify products still exist
        $validCart = [];
        $total = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product && !$product->trashed()) {
                $validCart[$item['id']] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        // Update cart cookie if products were removed
        if ($cart !== $validCart) {
            Cookie::queue('cart', json_encode($cart), 43200);
        }

        return view('pages.cart', ['cart' => $validCart, 'total' => $total]);
    }

    public function index(Request $request)
    {
        // Get cart from cookie
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        // Get selected product IDs from query parameters
        $selectedProducts = $request->query('selected_products', []);

        // Ensure selectedProducts is an array
        if (!is_array($selectedProducts)) {
            $selectedProducts = [$selectedProducts];
        }

        // Filter cart to include only selected products
        $selectedCart = [];
        $total = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product && !$product->trashed() && in_array($item['id'], $selectedProducts)) {
                $selectedCart[$item['id']] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        // If no products are selected, redirect back with an error
        if (empty($selectedCart)) {
            return redirect()->route('cart.cart')->with('error', 'Please select at least one product to proceed to checkout.');
        }

        // Store selected products in session for submit
        session(['selected_products' => $selectedProducts]);

        return view('pages.checkout', ['cart' => $selectedCart, 'total' => $total]);
    }

    public function submit(Request $request)
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
            return redirect()->route('cart.index')->with('error', 'Your cart is empty or no products selected.');
        }

        // Filter cart to include only selected products
        $selectedCart = [];
        $total = 0;
        foreach ($cart as $item) {
            if (in_array($item['id'], $selectedProducts)) {
                $selectedCart[$item['id']] = $item;
                $total += $item['price'] * $item['quantity'];
            }
        }

        if (empty($selectedCart)) {
            return redirect()->route('cart.index')->with('error', 'No valid products selected.');
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
        foreach ($selectedCart as $item) {
            OrderItem::create([
                'id' => (string) Str::uuid(),
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'name' => $item['name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Remove selected products from cart
        foreach ($selectedProducts as $productId) {
            unset($cart[$productId]);
        }
        Cookie::queue('cart', json_encode($cart), 43200);

        // Clear session
        session()->forget('selected_products');

        // Redirect to checkout with order details
        return redirect()->route('cart.index', ['order_id' => $order->id])
            ->with('success', 'Order placed successfully! Your order ID is ' . $order->id);
    }
}