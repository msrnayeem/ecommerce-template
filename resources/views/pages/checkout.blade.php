@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">Checkout</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="bg-white breadcrumb-checkout-page">
            <div class="border-b">
                <ul class="flex justify-between items-center w-full md:max-w-2xl mx-auto tracking-wide pt-1">
                    <li><span class="block text-primary font-bold border-b-4 border-primary py-2">চেক আউট</span></li>
                    <li><span class="block py-2"><span class="md:block hidden">সম্পন্ন</span></span></li>
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
                <h2 class="md:text-3xl text-2xl leading-tight">
                    অর্ডার টি সম্পন্ন করতে আপনার নাম, মোবাইল নাম্বার ও ঠিকানা নিচে লিখুন
                </h2>
            </div>

            <!-- Form Wrapper -->
            <div id="checkout-form-wrapper">
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
                @if (empty($cart))
                    <p class="text-gray-600 text-center">Your cart is empty.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-4 mx-auto block w-1/3">Continue Shopping</a>
                @else
                    <form action="{{ route('cart.submit') }}" method="post">
                        @csrf
                        <!-- Main Div Inside Form -->
                        <div class="flex mt-10 md:justify-center md:flex-row flex-col md:gap-20 form-inner-wrapper">
                            <!-- Left Part: Billing Details -->
                            <div class="md:w-1/2 p-2 form-inner-left-part">
                                <div class="flex flex-col mb-8 items-center md:items-start">
                                    <h3 class="md:text-xl text-lg font-bold md:text-left text-center">
                                        <span class="border-b-2 border-dashed border-gray-400">বিলিং ডিটেইল</span>
                                    </h3>
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="mb-2 block flex-[250px] mr-3 font-normal text-sm" for="name">আপনার নাম
                                        লিখুন
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" name="name" id="name" placeholder="সম্পূর্ণ নামটি লিখুন"
                                        class="w-full input input-bordered border border-solid border-slate-300 focus:outline-red-400 p-1 custom-checkout-bg"
                                        required>
                                    @error('name')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mobile Number -->
                                <div class="mb-3">
                                    <label class="mb-2 block flex-[250px] mr-3 font-normal text-sm" for="phone">আপনার
                                        মোবাইল নাম্বার লিখুন
                                        <span class="text-red-600">*</span></label>
                                    <input type="number" name="phone" id="phone" maxlength="11"
                                        class="w-full input input-bordered border border-solid border-slate-300 focus:outline-red-400 p-1 custom-checkout-bg"
                                        required>
                                    @error('phone')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-3 checkout-area-wrapper">
                                    <label class="mb-2 block flex-[250px] mr-3 font-normal text-sm"
                                        for="inset_address">সম্পূর্ণ ঠিকানা
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" name="inset_address" id="inset_address"
                                        placeholder="হাউস নাম্বার, রোড, ইউনিট/ফ্ল্যাট, পোস্ট কোড, জেলা"
                                        class="w-full input input-bordered border border-solid border-slate-300 focus:outline-red-400 p-1 custom-checkout-bg"
                                        required>
                                    @error('inset_address')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Delivery Area -->
                                <div class="mb-3 checkout-area-wrapper">
                                    <label class="mb-2 block flex-[250px] mr-3 font-normal text-sm delivery-area-label"
                                        for="deliveryTitle">এলাকা সিলেক্ট করুন
                                        <span class="text-red-600">*</span></label>
                                    <select name="deliveryTitle" id="deliveryTitle"
                                        class="w-full input input-bordered border border-solid border-slate-300 focus:outline-red-400 p-1 custom-checkout-bg"
                                        required>
                                        <option value="">এলাকা সিলেক্ট করুন</option>
                                        <option value="1">ঢাকা সিটির মধ্যে</option>
                                        <option value="2">ঢাকা সিটির বাহিরে</option>
                                    </select>
                                    @error('deliveryTitle')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Part: Product Details -->
                            <div class="md:my-0 md:w-1/2 md:min-w-[370px] p-2 form-inner-right-part">
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
                                        @foreach ($cart as $item)
                                            <tr class="my-2 flex justify-between items-center pr-2 shadow-md">
                                                <!-- Product Image and Details -->
                                                <td class="flex items-center p-2 w-4/5">
                                                    <div>
                                                        <img class="max-w-[80px]" alt="{{ $item['name'] }}"
                                                            src="{{ $item['image'] }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <h1 class="c-length text-lg md:font-semibold line-clamp">
                                                            {{ $item['name'] }}</h1>
                                                        <!-- Increment Decrement -->
                                                        <div class="mt-1 flex items-center">
                                                            <h2 class="mr-2">Qty:</h2>
                                                            <div
                                                                class="flex justify-between border border-gray-300 rounded px-1 w-[80px]">
                                                                <div class="flex justify-center items-center checkout-text-orange w-6 cursor-pointer"
                                                                    onclick="updateQuantity('{{ $item['id'] }}', -1)">
                                                                    <i class="bi bi-dash scale-150"></i>
                                                                </div>
                                                                <div class="text-center w-1/2">
                                                                    <h3 class="text-lg font-bold">{{ $item['quantity'] }}
                                                                    </h3>
                                                                </div>
                                                                <div class="flex justify-center items-center checkout-text-orange w-6 cursor-pointer"
                                                                    onclick="updateQuantity('{{ $item['id'] }}', 1)">
                                                                    <i class="bi bi-plus scale-150"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- Price and Remove -->
                                                <td class="text-right md:w-2/5 w-1/5 h-full flex flex-col">
                                                    <div>
                                                        <div class="flex items-center justify-end">
                                                            <strong>
                                                                <span>Tk </span><span
                                                                    class="text-xl">{{ number_format($item['price'] * $item['quantity']) }}</span>
                                                                @if ($item['original_price'] && $item['original_price'] > $item['price'])
                                                                    <span class="text-sm text-red-500 line-through">
                                                                        (Tk
                                                                        {{ number_format($item['original_price'] * $item['quantity']) }})
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </div>
                                                        <div>
                                                            <form action="{{ route('cart.remove') }}" method="post"
                                                                class="inline">
                                                                @csrf
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $item['id'] }}">
                                                                <button type="submit"
                                                                    class="text-black underline hover:text-red-600 transition hover:cursor-pointer">Remove</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- SubTotal -->
                                        <tr class="flex justify-between border-t border-dashed border-gray-400 py-2 px-2">
                                            <td class="text-sm">সাব-টোটাল (+)</td>
                                            <td></td>
                                            <td class="text-right text-xl">
                                                <strong><span>Tk </span><span>{{ number_format($total) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="flex justify-between py-2 px-2">
                                            <th class="text-left font-bold">টোটাল</th>
                                            <th></th>
                                            <th class="text-right text-xl">
                                                <strong><span>Tk </span><span
                                                        class="text-xl font-bold">{{ number_format($total) }}</span></strong>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Choose Payment Method -->
                                <div class="my-5">
                                    <ul>
                                        <li class="my-4 border-b border-solid border-gray-200">
                                            <label class="flex items-center gap-2 mb-2">
                                                <input type="radio" name="payment_method" value="Cash On Delivery"
                                                    checked>
                                                <span>Cash On Delivery</span>
                                            </label>
                                            <p>পন্য হাতে পেয়ে টাকা পরিশোধ করবেন</p>
                                        </li>
                                        <li class="my-4 border-b border-solid border-gray-200">
                                            <label class="flex items-center gap-2 mb-2">
                                                <input type="radio" name="payment_method" value="Bkash">
                                                <span>Bkash</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <button type="submit"
                                        class="w-full uppercase md:p-3 p-5 font-bold text-sm md:mt-2 mt-10 !h-auto checkout-orange-bg text-white flex justify-center items-center gap-3 relative">
                                        <svg class="mb-1" fill="#fff" height="16" width="16"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 330 330" xml:space="preserve"
                                            stroke="#fff">
                                            <path
                                                d="M65 330h200c8.284 0 15-6.716 15-15V145c0-8.284-6.716-15-15-15h-15V85c0-46.869-38.131-85-85-85S80 38.131 80 85v45H65c-8.284 0-15 6.716-15 15v170c0 8.284 6.716 15 15 15zm115-95.014V255c0 8.284-6.716 15-15 15s-15-6.716-15-15v-20.014c-6.068-4.565-10-11.824-10-19.986 0-13.785 11.215-25 25-25s25 11.215 25 25c0 8.162-3.932 15.421-10 19.986zM110 85c0-30.327 24.673-55 55-55s55 24.673 55 55v45H110V85z">
                                            </path>
                                        </svg>
                                        <span>
                                            অর্ডার টি কনফার্ম করুন
                                            <span class="font-normal">{{ number_format($total) }}</span>
                                            <span class="font-normal"> Tk</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <script>
        function updateQuantity(productId, change) {
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        change: change
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.error || 'Error updating quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating quantity');
                });
        }
    </script>
@endsection
