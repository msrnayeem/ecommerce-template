@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('cart.cart') }}" class="">Cart</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">Checkout</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('cart.cart') }}" class="">Back to Cart</a></li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="bg-white breadcrumb-checkout-page">
            <div class="border-b">
                <ul class="flex justify-between items-center w-full md:max-w-2xl mx-auto tracking-wide pt-1">
                    <li>
                        <span class="block py-2">চেক আউট</span>
                    </li>
                    <li>
                        <span class="block py-2 text-primary font-bold border-b-4 border-primary">
                            <span class="md:block hidden">সম্পন্ন</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section class="pt-5 pb-20">
        <div id="checkout-now"
            class="checkout-container flex flex-col border-solid border-gray-300 border-2 md:px-7 px-4 md:pb-20 md:pt-5 py-14 xl:mx-auto mx-2 my-2 rounded-3xl shadow-lg custom-checkout-bg">
            <!-- Heading -->
            <div
                class="checkout-text-orange page-title text-center font-bold w-2/3 mx-auto md:mb-5 border-b-4 border-dashed border-gray-400 pb-2">
                <h2 class="md:text-3xl text-2xl leading-tight">অর্ডার সম্পন্ন হয়েছে</h2>
            </div>

            <!-- Content -->
            <div id="success-content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success mb-4 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error mb-4 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($order)
                    <div class="flex flex-col md:flex-row mt-10 md:gap-20 form-inner-wrapper">
                        <!-- Order Details -->
                        <div class="md:w-1/2 p-2">
                            <h3 class="md:text-xl text-lg font-bold mb-8 md:text-left text-center">
                                <span class="border-b-2 border-dashed border-gray-400">অর্ডার ডিটেইল</span>
                            </h3>
                            <p><strong>অর্ডার আইডি:</strong> MSBD-ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>নাম:</strong> {{ $order->customer_name }}</p>
                            <p><strong>মোবাইল নাম্বার:</strong> {{ $order->customer_phone }}</p>
                            <p><strong>ঠিকানা:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>ডেলিভারি এলাকা:</strong> {{ $order->shipping_method }}</p>
                            <p><strong>পেমেন্ট মেথড:</strong> {{ $order->payment_method }}</p>
                            <p><strong>স্ট্যাটাস:</strong> {{ ucfirst($order->status) }}</p>
                            <div class="mt-6">
                                <a href="{{ route('order.invoice', ['order_id' => $order->id]) }}"
                                    class="btn btn-success w-full md:w-1/3 uppercase md:p-3 p-5 font-bold text-sm">
                                    Download Invoice
                                </a>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="md:w-1/2 p-2">
                            <h3 class="md:text-xl text-lg font-bold mb-8 md:text-left text-center">
                                <span class="border-b-2 border-dashed border-gray-400">প্রোডাক্ট ডিটেইল</span>
                            </h3>
                            <table class="flex flex-col w-full">
                                <thead class="border-b border-dashed border-gray-400">
                                    <tr class="flex justify-between px-2">
                                        <th class="text-left font-bold text-sm">প্রোডাক্ট নাম</th>
                                        <th></th>
                                        <th class="text-right font-bold text-sm">বিক্রয় মূল্য</th>
                                    </tr>
                                </thead>
                                <tbody class="border-b border-dashed border-gray-400">
                                    @foreach ($order->orderItems as $item)
                                        <tr class="my-2 flex justify-between items-center pr-2 shadow-md">
                                            <td class="flex items-center p-2 w-4/5">
                                                <div>
                                                    <img class="max-w-[80px]" alt="{{ $item->display_name }}"
                                                        src="{{ env('IMAGE_LINK') . $item->image_path }}">
                                                </div>
                                                <div class="ml-4">
                                                    <h1 class="c-length text-lg md:font-semibold line-clamp">
                                                        {{ $item->display_name }}
                                                    </h1>
                                                    <p class="text-sm">Qty: {{ $item->quantity }}</p>
                                                    @if ($item->orderable instanceof \App\Models\ProductVariant)
                                                        <p class="text-sm">
                                                            Variant: {{ $item->orderable->variant->name ?? '' }} -
                                                            {{ $item->orderable->variantValue->name ?? '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-right md:w-2/5 w-1/5">
                                                <strong>
                                                    <span>Tk </span>
                                                    <span class="text-xl">{{ number_format($item->total, 2) }}</span>
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Delivery Charge -->
                                    <tr class="flex justify-between border-t border-dashed border-gray-400 py-2 px-2">
                                        <td class="text-sm">ডেলিভারি চার্জ</td>
                                        <td></td>
                                        <td class="text-right text-xl">
                                            <strong><span>Tk </span>
                                                <span>{{ number_format($order->delivery_charge, 2) }}</span></strong>
                                        </td>
                                    </tr>

                                    <!-- Total -->
                                    <tr class="flex justify-between border-t border-dashed border-gray-400 py-2 px-2">
                                        <td class="text-sm">টোটাল</td>
                                        <td></td>
                                        <td class="text-right text-xl">
                                            <strong><span>Tk </span>
                                                <span>{{ number_format($order->total_amount, 2) }}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('home') }}"
                                    class="btn btn-primary w-full md:w-1/3 uppercase md:p-3 p-5 font-bold text-sm">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 text-center">Order not found.</p>
                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}"
                            class="btn btn-primary w-full md:w-1/3 uppercase md:p-3 p-5 font-bold text-sm">
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
