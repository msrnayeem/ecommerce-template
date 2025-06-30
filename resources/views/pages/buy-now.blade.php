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
                <form action="{{ route('cart.submit') }}" method="post">
                    @csrf
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
                                <select name="deliveryTitle" class="w-full border border-gray-300 p-2 rounded" required>
                                    <option value="">সিলেক্ট করুন</option>
                                    <option value="1">ঢাকা সিটির মধ্যে</option>
                                    <option value="2">ঢাকা সিটির বাহিরে</option>
                                </select>
                            </div>

                            @if ($product->variants->count())
                                <div class="mb-5">
                                    <label class="block mb-2 font-medium">ভ্যারিয়েন্ট সিলেক্ট করুন <span
                                            class="text-red-500">*</span></label>
                                    <select name="variant_id" class="w-full border border-gray-300 p-2 rounded" required>
                                        <option value="">একটি বেছে নিন</option>
                                        @foreach ($product->variants as $variant)
                                            <option value="{{ $variant->id }}">{{ $variant->variant_name }} -
                                                {{ $variant->variant_value }} (Tk {{ number_format($variant->price) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
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
                                        Qty:
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="border border-gray-300 p-1 w-16 text-center">
                                        <br>
                                        Price: Tk {{ number_format($cart[0]['price']) }}
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
                                    অর্ডার টি কনফার্ম করুন (Tk {{ number_format($total) }})
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
