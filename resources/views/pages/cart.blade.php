{{-- cart --}}
@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <nav class="container mx-auto text-sm flex justify-between items-center">
            <ol class="flex flex-wrap items-center space-x-2">
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a></li>
                <li><i class="bi bi-chevron-right text-gray-500"></i></li>
                <li class="text-gray-700">Cart</li>
            </ol>
            <ol class="flex items-center space-x-2">
                <li><i class="bi bi-chevron-left text-gray-500"></i></li>
                <li><a href="{{ route('home') }}" class="text-blue-600 hover:underline">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="py-10 bg-gray-50">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-center mb-8 text-gray-800">Your Cart</h1>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-md text-center">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow-md text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if (empty($cart))
                <div class="text-center">
                    <p class="text-gray-600 text-lg mb-4">Your cart is empty.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block bg-blue-600 text-black py-3 px-6 rounded-lg hover:bg-blue-700 transition">Continue
                        Shopping</a>
                </div>
            @else
                <!-- Debug: Display cart count -->
                <p class="text-center text-gray-600 mb-4">Items in cart: {{ count($cart) }}</p>
                <form action="{{ route('cart.index') }}" method="GET" id="cart-form">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr class="text-left text-gray-600 text-sm uppercase">
                                        <th class="py-4 px-6">Select</th>
                                        <th class="py-4 px-6">Product</th>
                                        <th class="py-4 px-6">Price</th>
                                        <th class="py-4 px-6 text-center">Quantity</th>
                                        <th class="py-4 px-6 text-center">Total</th>
                                        {{-- <th class="py-4 px-6 text-center">Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $cartKey => $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-4 px-6">
                                                <input type="checkbox" name="selected_products[]"
                                                    value="{{ $cartKey }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded" checked>
                                            </td>
                                            @php
                                                $imageLink = env('IMAGE_LINK', 'http://localhost:8000'); // Fallback to localhost if IMAGE_LINK is not set
                                            @endphp
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <img src="{{ $imageLink . '/product-image/' . basename($item['image']) }}"
                                                        alt="product-image" class="w-16 h-16 object-contain rounded mr-4">
                                                    <div>
                                                        <h4 class="font-semibold text-gray-800">{{ $item['name'] }}</h4>
                                                        @if ($item['variant_id'])
                                                            <p class="text-sm text-gray-500">
                                                                {{ $item['variant_name'] ?? 'N/A' }}:
                                                                {{ $item['variant_value'] ?? 'N/A' }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <p class="font-semibold text-gray-800">Tk
                                                    {{ number_format($item['price']) }}</p>
                                                @if ($item['original_price'] && $item['original_price'] > $item['price'])
                                                    <p class="text-sm text-red-500 line-through">Tk
                                                        {{ number_format($item['original_price']) }}</p>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex items-center justify-center">
                                                    <button type="button"
                                                        onclick="updateQuantity('{{ $cartKey }}', -1)"
                                                        class="w-8 h-8 flex items-center justify-center bg-gray-200 text-gray-600 rounded-l hover:bg-gray-300">-</button>
                                                    <input type="number" value="{{ $item['quantity'] }}"
                                                        class="w-12 text-center border-t border-b border-gray-200" readonly>
                                                    <button type="button"
                                                        onclick="updateQuantity('{{ $cartKey }}', 1)"
                                                        class="w-8 h-8 flex items-center justify-center bg-gray-200 text-gray-600 rounded-r hover:bg-gray-300">+</button>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <p class="font-semibold text-gray-800">Tk
                                                    {{ number_format($item['price'] * $item['quantity']) }}</p>
                                            </td>
                                            {{-- <td class="py-4 px-6 text-center">
                                                <form action="{{ route('cart.remove') }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 transition">Remove</button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-100">
                                        <td colspan="4" class="py-4 px-6 text-right font-semibold text-gray-800">
                                            Total:</td>
                                        <td class="py-4 px-6 text-center font-bold text-gray-800">Tk
                                            {{ number_format($total) }}</td>
                                        <td class="py-4 px-6"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="p-6 flex justify-end m-4">
                            <button type="submit"
                                class="bg-blue-600 text-black  py-3 px-6 rounded-lg shadow-md transition text-sm font-semibold uppercase">
                                Proceed to Checkout
                            </button>
                        </div>

                    </div>
                </form>
            @endif
        </div>
    </section>

    <script>
        function updateQuantity(cartKey, change) {
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart_key: cartKey,
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

        document.getElementById('cart-form').addEventListener('submit', function(e) {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            if (selectedProducts.length === 0) {
                e.preventDefault();
                alert('Please select at least one item to proceed to checkout.');
            }
        });
    </script>
@endsection
