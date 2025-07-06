{{-- buy-now --}}
@extends('layouts.app')

@section('content')
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">Checkout</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('home') }}">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="pt-5 pb-20">
        <div
            class="checkout-container flex flex-col border-solid border-gray-300 border-2 md:px-7 px-4 md:pb-20 md:pt-5 py-14 xl:mx-auto mx-2 my-2 rounded-3xl shadow-lg custom-checkout-bg">
            <div
                class="checkout-text-orange page-title text-center font-bold w-2/3 mx-auto md:mb-5 border-b-4 border-dashed border-gray-400 pb-2">
                <h2 class="md:text-3xl text-2xl leading-tight">
                    অর্ডার টি সম্পন্ন করতে আপনার নাম, মোবাইল নাম্বার ও ঠিকানা নিচে লিখুন
                </h2>
            </div>

            <div id="checkout-form-wrapper">
                <form action="{{ route('order.submit') }}" method="post">
                    @csrf
                    <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                    <input type="hidden" name="items[0][variant_id]" value="{{ $cart[0]['variant_id'] ?? '' }}">
                    <input type="hidden" id="cart-quantity" name="items[0][quantity]" value="1">

                    <div class="flex mt-10 md:justify-center md:flex-row flex-col md:gap-20 form-inner-wrapper">
                        <div class="md:w-1/2 p-2 form-inner-left-part">
                            <div class="mb-5">
                                <label class="block mb-2 font-medium">আপনার নাম <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded"
                                    required>
                            </div>

                            <div class="mb-5">
                                <label class="block mb-2 font-medium">মোবাইল নাম্বার <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="phone" class="w-full border border-gray-300 p-2 rounded"
                                    required>
                            </div>

                            <div class="mb-5">
                                <label class="block mb-2 font-medium">ঠিকানা <span class="text-red-500">*</span></label>
                                <input type="text" name="inset_address" class="w-full border border-gray-300 p-2 rounded"
                                    required>
                            </div>

                            <div class="mb-5">
                                <label class="block mb-2 font-medium">ডেলিভারি এলাকা <span
                                        class="text-red-500">*</span></label>
                                <select name="deliveryTitle" id="deliveryTitle"
                                    class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="">সিলেক্ট করুন</option>
                                    <option value="1" data-charge="60">ঢাকা সিটির মধ্যে</option>
                                    <option value="2" data-charge="120">ঢাকা সিটির বাহিরে</option>
                                </select>
                            </div>
                        </div>

                        <div class="md:w-1/2 p-2 form-inner-right-part">
                            <h3 class="text-xl font-bold mb-4">প্রোডাক্ট ডিটেইল</h3>
                            <table class="w-full border">
                                <tr>
                                    <td>
                                        <img src="{{ $cart[0]['image'] }}" class="w-24 h-24 object-cover">
                                    </td>
                                    <td class="pl-4">
                                        <strong>{{ $cart[0]['name'] }}</strong><br>
                                        SKU: {{ $cart[0]['sku'] ?? 'N/A' }}<br>
                                        @if ($cart[0]['variant_id'])
                                            <span>Variant: {{ $cart[0]['variant_name'] ?? '-' }} </span> <br>
                                        @endif
                                        Qty:
                                        <div class="flex items-center gap-2 mt-1">
                                            <button type="button" onclick="updateQuantity(-1)"
                                                class="bg-gray-200 px-2 py-1 rounded">-</button>
                                            <input type="number" id="quantity" name="quantity" value="1"
                                                min="1" class="border border-gray-300 p-1 w-16 text-center" readonly>
                                            <button type="button" onclick="updateQuantity(1)"
                                                class="bg-gray-200 px-2 py-1 rounded">+</button>
                                        </div>
                                        <br>
                                        <span>Price: Tk <span
                                                id="unitPrice">{{ number_format($cart[0]['price']) }}</span></span><br>
                                        <span>Subtotal: Tk <span
                                                id="subtotal">{{ number_format($cart[0]['price']) }}</span></span><br>
                                        <span>Delivery: Tk <span id="deliveryCharge">0</span></span><br>
                                        <span>Total: Tk <span
                                                id="totalPrice">{{ number_format($cart[0]['price']) }}</span></span>
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-6">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payment_method" value="Cash On Delivery" checked>
                                    Cash On Delivery
                                </label>
                                <label class="flex items-center gap-2 mt-2">
                                    <input type="radio" name="payment_method" value="Bkash">
                                    Bkash
                                </label>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 w-full font-bold rounded">
                                    অর্ডার টি কনফার্ম করুন (Tk <span id="buttonTotal">{{ number_format($total) }}</span>)
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        const unitPrice = {{ $cart[0]['price'] }};
        let quantity = 1;
        let deliveryCharge = 0;

        function updateQuantity(change) {
            quantity = Math.max(1, quantity + change);
            document.getElementById('quantity').value = quantity;
            document.getElementById('cart-quantity').value = quantity;
            updatePrice();
        }

        function updatePrice() {
            const subtotal = unitPrice * quantity;
            const total = subtotal + deliveryCharge;

            document.getElementById('subtotal').textContent = subtotal.toLocaleString();
            document.getElementById('totalPrice').textContent = total.toLocaleString();
            document.getElementById('buttonTotal').textContent = total.toLocaleString();
        }

        document.getElementById('deliveryTitle').addEventListener('change', function() {
            deliveryCharge = parseInt(this.options[this.selectedIndex].getAttribute('data-charge')) || 0;
            document.getElementById('deliveryCharge').textContent = deliveryCharge.toLocaleString();
            updatePrice();
        });

        updatePrice();
    </script>
@endsection
