@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">Cart</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="pt-5 pb-20">
        <div class="container mx-auto">
            <h1 class="md:text-3xl text-2xl font-bold text-center mb-6 checkout-text-orange">Your Cart</h1>

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
                <form action="{{ route('cart.index') }}" method="GET" id="cart-form">
                    <div class="border rounded-lg p-4 bg-white shadow-md">
                        <table class="flex flex-col w-full">
                            <thead class="border-b border-dashed border-gray-400">
                                <tr class="flex justify-between px-2">
                                    <th class="text-left font-bold text-sm w-1/12">Select</th>
                                    <th class="text-left font-bold text-sm w-4/12">প্রোডাক্ট নাম</th>
                                    <th class="w-3/12"></th>
                                    <th class="text-right font-bold text-sm w-4/12">বিক্রয় মূল্য</th>
                                </tr>
                            </thead>
                            <tbody class="border-b border-dashed border-gray-400">
                                @foreach ($cart as $item)
                                    <tr class="my-2 flex justify-between items-center pr-2 shadow-md">
                                        <!-- Checkbox -->
                                        <td class="w-1/12 p-2">
                                            <input type="checkbox" name="selected_products[]" value="{{ $item['id'] }}"
                                                class="form-checkbox h-5 w-5 text-primary" checked>
                                        </td>
                                        <!-- Product Image and Details -->
                                        <td class="flex items-center p-2 w-4/12">
                                            <div>
                                                <img class="max-w-[80px]" alt="{{ $item['name'] }}"
                                                    src="{{ $item['image'] }}">
                                            </div>
                                            <div class="ml-4">
                                                <h1 class="c-length text-lg md:font-semibold line-clamp">{{ $item['name'] }}
                                                </h1>
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
                                                            <h3 class="text-lg font-bold">{{ $item['quantity'] }}</h3>
                                                        </div>
                                                        <div class="flex justify-center items-center checkout-text-orange w-6 cursor-pointer"
                                                            onclick="updateQuantity('{{ $item['id'] }}', 1)">
                                                            <i class="bi bi-plus scale-150"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Spacer -->
                                        <td class="w-3/12"></td>
                                        <!-- Price and Remove -->
                                        <td class="text-right w-4/12 h-full flex flex-col">
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
                                    <td class="text-sm w-1/12"></td>
                                    <td class="text-sm w-4/12">সাব-টোটাল (+)</td>
                                    <td class="w-3/12"></td>
                                    <td class="text-right text-xl w-4/12">
                                        <strong><span>Tk </span><span>{{ number_format($total) }}</span></strong>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="flex justify-between py-2 px-2">
                                    <th class="text-left font-bold w-1/12"></th>
                                    <th class="text-left font-bold w-4/12">টোটাল</th>
                                    <th class="w-3/12"></th>
                                    <th class="text-right text-xl w-4/12">
                                        <strong><span>Tk </span><span
                                                class="text-xl font-bold">{{ number_format($total) }}</span></strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="btn btn-success w-full md:w-1/3 uppercase md:p-3 p-5 font-bold text-sm checkout-orange-bg text-white">Proceed
                                to Checkout</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>

    <script>
        function updateQuantity(productId, change) {
            // Store checkbox states
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            const checkedStates = Array.from(checkboxes).map(cb => ({
                id: cb.value,
                checked: cb.checked
            }));

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
                        // Reload page and restore checkbox states
                        location.reload();
                        document.addEventListener('DOMContentLoaded', () => {
                            checkedStates.forEach(state => {
                                const checkbox = document.querySelector(
                                    `input[name="selected_products[]"][value="${state.id}"]`);
                                if (checkbox) checkbox.checked = state.checked;
                            });
                        });
                    } else {
                        alert(data.error || 'Error updating quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating quantity');
                });
        }

        // Validate at least one product is selected before submitting
        document.getElementById('cart-form').addEventListener('submit', function(e) {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            if (selectedProducts.length === 0) {
                e.preventDefault();
                alert('Please select at least one product to proceed to checkout.');
            }
        });
    </script>
@endsection
