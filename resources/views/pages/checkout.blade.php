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
                    <form action="{{ route('cart.submit') }}" method="post" id="checkoutForm">
                        @csrf
                        <div class="flex mt-10 md:justify-center md:flex-row flex-col md:gap-20 form-inner-wrapper">
                            <div class="md:w-1/2 p-2 form-inner-left-part">
                                <div class="mb-5">
                                    <label class="block mb-2 font-medium">আপনার নাম <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="name"
                                        class="w-full border border-gray-300 p-2 rounded custom-checkout-bg" required>
                                    @error('name')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="block mb-2 font-medium">মোবাইল নাম্বার <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="phone" maxlength="11"
                                        class="w-full border border-gray-300 p-2 rounded custom-checkout-bg" required>
                                    @error('phone')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="block mb-2 font-medium">ঠিকানা <span class="text-red-500">*</span></label>
                                    <input type="text" name="inset_address"
                                        placeholder="হাউস নাম্বার, রোড, ইউনিট/ফ্ল্যাট, পোস্ট কোড, জেলা"
                                        class="w-full border border-gray-300 p-2 rounded custom-checkout-bg" required>
                                    @error('inset_address')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="block mb-2 font-medium">ডেলিভারি এলাকা <span
                                            class="text-red-500">*</span></label>
                                    <select name="deliveryTitle" id="deliveryTitle"
                                        class="w-full border border-gray-300 p-2 rounded custom-checkout-bg" required>
                                        <option value="">সিলেক্ট করুন</option>
                                        <option value="1" data-charge="60">ঢাকা সিটির মধ্যে</option>
                                        <option value="2" data-charge="120">ঢাকা সিটির বাহিরে</option>
                                    </select>
                                    @error('deliveryTitle')
                                        <p class="text-red-500 p-2 bg-slate-100 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="md:w-1/2 p-2 form-inner-right-part">
                                <h3 class="text-xl font-bold mb-4">প্রোডাক্ট ডিটেইল</h3>
                                <table class="w-full border">
                                    @foreach ($cart as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item['image'] }}" class="w-24 h-24 object-cover">
                                            </td>
                                            <td class="pl-4">
                                                <strong>{{ $item['name'] }}</strong><br>
                                                SKU: {{ $item['sku'] ?? 'N/A' }}<br>
                                                @if ($item['variant_id'])
                                                    <span>Variant: {{ $item['variant_value'] }}</span><br>
                                                @endif
                                                Qty:
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                        onclick="updateQuantity('{{ $item['id'] }}', -1)"
                                                        class="bg-gray-200 px-2 py-1 rounded">-</button>
                                                    <input type="number" id="quantity-{{ $item['id'] }}"
                                                        name="items[{{ $item['id'] }}][quantity]"
                                                        value="{{ $item['quantity'] }}" min="1"
                                                        class="border border-gray-300 p-1 w-16 text-center" readonly>
                                                    <button type="button"
                                                        onclick="updateQuantity('{{ $item['id'] }}', 1)"
                                                        class="bg-gray-200 px-2 py-1 rounded">+</button>
                                                </div>
                                                <input type="hidden" name="items[{{ $item['id'] }}][sku]"
                                                    value="{{ $item['sku'] ?? 'N/A' }}">
                                                <input type="hidden" name="items[{{ $item['id'] }}][variant_id]"
                                                    value="{{ $item['variant_id'] ?? '' }}">
                                                <input type="hidden" id="price-{{ $item['id'] }}"
                                                    value="{{ $item['price'] }}">
                                                <br>
                                                <span>Price: Tk <span
                                                        id="unitPrice-{{ $item['id'] }}">{{ number_format($item['price']) }}</span></span><br>
                                                <span>Subtotal: Tk <span
                                                        id="subtotal-{{ $item['id'] }}">{{ number_format($item['price'] * $item['quantity']) }}</span></span><br>
                                                <form action="{{ route('cart.remove') }}" method="post" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                                    <button type="submit"
                                                        class="text-black underline hover:text-red-600 transition">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="pt-4">
                                            <span>Delivery: Tk <span id="deliveryCharge">0</span></span><br>
                                            <span>Total: Tk <span
                                                    id="totalPrice">{{ number_format($total) }}</span></span>
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
                                        অর্ডার টি কনফার্ম করুন (Tk <span
                                            id="buttonTotal">{{ number_format($total) }}</span>)
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
        // Initialize delivery charge
        let deliveryCharge = 0;

        // Update quantity and recalculate prices
        function updateQuantity(productId, change) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            let quantity = parseInt(quantityInput.value) || 1;
            quantity = Math.max(1, quantity + change); // Ensure quantity doesn't go below 1
            quantityInput.value = quantity;

            // Update subtotal for this product
            const price = parseFloat(document.getElementById(`price-${productId}`).value);
            const subtotal = price * quantity;
            document.getElementById(`subtotal-${productId}`).textContent = subtotal.toLocaleString('en-US', {
                minimumFractionDigits: 0
            });

            // Update total price
            updateTotalPrice();
        }

        // Calculate and update total price
        function updateTotalPrice() {
            let totalSubtotal = 0;
            // Iterate over all cart items to calculate total subtotal
            document.querySelectorAll('input[name^="items["][name$="[quantity]"]').forEach(input => {
                const productId = input.id.split('-')[1];
                const quantity = parseInt(input.value) || 1;
                const price = parseFloat(document.getElementById(`price-${productId}`).value);
                totalSubtotal += price * quantity;
            });

            // Add delivery charge to total
            const total = totalSubtotal + deliveryCharge;

            // Update UI elements
            document.getElementById('totalPrice').textContent = total.toLocaleString('en-US', {
                minimumFractionDigits: 0
            });
            document.getElementById('buttonTotal').textContent = total.toLocaleString('en-US', {
                minimumFractionDigits: 0
            });
        }

        // Update delivery charge on selection
        document.getElementById('deliveryTitle').addEventListener('change', function() {
            deliveryCharge = parseInt(this.options[this.selectedIndex].getAttribute('data-charge')) || 0;
            document.getElementById('deliveryCharge').textContent = deliveryCharge.toLocaleString('en-US', {
                minimumFractionDigits: 0
            });
            updateTotalPrice(); // Recalculate total with new delivery charge
        });

        // Initialize prices on page load
        updateTotalPrice();
    </script>
@endsection
