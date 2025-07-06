@extends('layouts.app')

@section('content')
    @php
        $imageLink = env('IMAGE_LINK', 'http://localhost:8000');
        $hasVariants = $product->has_variant;
        $firstVariant = $hasVariants ? $product->productVariants->first() : null;
        $variantPrice = $hasVariants && $firstVariant ? $firstVariant->discount_price ?? $firstVariant->price : null;
        $variantStock = $hasVariants && $firstVariant ? $firstVariant->stock : null;
        $productPrice = !$hasVariants ? $product->discount_price ?? $product->price : null;
        $productStock = !$hasVariants ? $product->stock : null;
        $currentDateTime = now()->setTimezone('Asia/Dhaka')->format('h:i A +06, l, F d, Y'); // 01:14 PM +06, Sunday, July 06, 2025
    @endphp

    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2"><a
                        href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                </li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">{{ $product->name }}</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('home') }}">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="product-details-wrapper container mx-auto md:py-5 relative z-[90]">
        <div class="stx-product-details-container grid grid-cols-10 md:grid-cols-10 gap-2 md:gap-7 mb-6">
            <div class="lg:col-span-5 md:col-span-5 col-span-10 product-details-image mt-3">
                <div class="border p-0 md:p-5" id="custom-image-gallery">
                    <!-- Main Image Container -->
                    <div class="main-image-container relative">
                        <button class="nav-btn prev" onclick="changeImage(-1)">❮</button>
                        <div class="flexImg">
                            @forelse($product->productImages as $index => $image)
                                @if ($index === 0)
                                    <img src="{{ $imageLink . '/product-image/' . basename($image->path) }}"
                                        alt="{{ $image->caption ?? $product->name }}" class="main-image active"
                                        style="width: 400px; height: 300px; object-fit: contain;">
                                    <div class="zoomImg">
                                        <img src="{{ $imageLink . '/product-image/' . basename($image->path) }}"
                                            alt="{{ $image->caption ?? $product->name }}" class="zoom-image active"
                                            style="width: 400px; height: 300px; object-fit: contain;">
                                    </div>
                                @else
                                    <img src="{{ $imageLink . '/product-image/' . basename($image->path) }}"
                                        alt="{{ $image->caption ?? $product->name }}" class="main-image"
                                        style="display: none; width: 400px; height: 300px; object-fit: contain;">
                                    <div class="zoomImg">
                                        <img src="{{ $imageLink . '/product-image/' . basename($image->path) }}"
                                            alt="{{ $image->caption ?? $product->name }}" class="zoom-image"
                                            style="display: none; width: 400px; height: 300px; object-fit: contain;">
                                    </div>
                                @endif
                            @empty
                                <img src="https://via.placeholder.com/150" alt="No image" class="main-image active"
                                    style="width: 400px; height: 300px; object-fit: contain;">
                                <div class="zoomImg">
                                    <img src="https://via.placeholder.com/150" alt="No image" class="zoom-image active"
                                        style="width: 400px; height: 300px; object-fit: contain;">
                                </div>
                            @endforelse
                        </div>
                        <button class="nav-btn next" onclick="changeImage(1)">❯</button>
                    </div>

                    <!-- Thumbnail Navigation -->
                    <div class="thumbnail-container mt-5">
                        @forelse($product->productImages as $index => $image)
                            <img src="{{ $imageLink . '/product-image/' . basename($image->path) }}"
                                alt="{{ $image->caption ?? $product->name }}"
                                class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                onclick="selectThumbnail({{ $index }})"
                                style="width: 100px; height: 60px; object-fit: cover; cursor: pointer; margin-right: 10px;">
                        @empty
                            <img src="https://via.placeholder.com/150" alt="No image" class="thumbnail active"
                                onclick="selectThumbnail(0)"
                                style="width: 100px; height: 60px; object-fit: cover; cursor: pointer; margin-right: 10px;">
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 md:col-span-5 col-span-10 product-details-content mt-3">
                <div class="md:p-5 p-0 md:border">
                    <div class="stx-product-details-product-info">
                        <h2 class="text-xl md:text-2xl font-semibold">{{ $product->name }}</h2>
                        <div class="flex justify-between">
                            <div><strong class="text-lg uppercase">SKU:</strong> {{ $product->sku }}</div>
                        </div>
                        <div class="flex items-center mb-2">
                            <strong class="text-lg uppercase">PRICE:</strong>
                            <span class="text-lg md:text-xl ml-1 font-bold" id="display-price-wrap">
                                <ins class="text-primary" id="display-price">
                                    Tk
                                    {{ $hasVariants ? number_format($variantPrice) : number_format($productPrice) }}
                                </ins>
                                @if ($hasVariants && $firstVariant && $firstVariant->discount_price)
                                    <del class="text-gray-400 font-normal ml-2" id="display-old-price">Tk
                                        {{ number_format($firstVariant->price) }}</del>
                                    <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1"
                                        id="display-discount">{{ number_format($firstVariant->price - $firstVariant->discount_price) }}
                                        Tk off</span>
                                @elseif(!$hasVariants && $product->discount_price)
                                    <del class="text-gray-400 font-normal ml-2" id="display-old-price">Tk
                                        {{ number_format($product->price) }}</del>
                                    <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1"
                                        id="display-discount">{{ number_format($product->price - $product->discount_price) }}
                                        Tk off</span>
                                @endif
                            </span>
                        </div>

                        @if ($product->productVariants->count())
                            <div class="mb-4">
                                <label for="variant-select" class="text-lg uppercase font-bold mb-1 block">Choose
                                    Variant:</label>
                                <select id="variant-select" name="variant_id" class="border rounded p-2 w-full max-w-xs">
                                    @foreach ($product->productVariants as $variant)
                                        <option value="{{ $variant->id }}"
                                            data-price="{{ $variant->discount_price ?? $variant->price }}"
                                            data-old-price="{{ $variant->price }}"
                                            data-discount="{{ $variant->discount_price ? number_format($variant->price - $variant->discount_price) : 0 }}"
                                            data-stock="{{ $variant->stock }}">
                                            {{ $variant->variantValue->name ?? 'Variant' }} (Tk
                                            {{ number_format($variant->discount_price ?? $variant->price) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <strong class="text-lg uppercase" id="status-text">
                            Status: <span class="text-success capitalize">
                                {{ ($hasVariants ? $variantStock : $productStock) > 0 ? 'In Stock' : 'Out of Stock' }}
                                @if (($hasVariants ? $variantStock : $productStock) !== null)
                                    ({{ $hasVariants ? $variantStock : $productStock }})
                                @endif
                            </span>
                        </strong>

                        <div>
                            <div class="quantity-wrap flex md:py-3 md:mr-0 mr-3 mb-2">
                                <label for="qty"
                                    class="text-lg uppercase md:block hidden font-bold mt-2 mr-4">Quantity</label>
                                <span
                                    class="decrease-qty md:px-3 px-4 md:py-2 py-[6px] cursor-pointer qty-button border border-gray-200 border-solid">-</span>
                                <input type="number" id="qty"
                                    class="w-12 text-center qty-button md:text-lg text-sm font-bold border" name="qty"
                                    min="1" value="1" oninput="this.value = Math.floor(this.value)"
                                    max="{{ $hasVariants ? $variantStock : $productStock }}">
                                <span
                                    class="increase-qty md:px-3 px-4 md:py-2 py-[6px] cursor-pointer qty-button border border-gray-200 border-solid">+</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 flex form-cart-wrap align-items-center mb-1">
                                <form action="{{ route('cart.add') }}" method="post" class="w-full">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="cart-qty" value="1">
                                    @if ($product->productVariants->count())
                                        <input type="hidden" name="variant_id" id="selected-variant-id"
                                            value="{{ $product->productVariants->first()->id }}">
                                    @endif
                                    <button type="submit" class="btn btn-success w-full submit-btn border-0">কার্ড এ
                                        যুক্ত করুন</button>
                                </form>
                                @if ($product->productVariants->count())
                                    <a href="{{ route('buy.now', ['sku' => $product->sku, 'variant' => $product->productVariants->first()->id]) }}"
                                        class="btn btn-success w-full submit-btn border-0">Order Now</a>
                                @else
                                    <a href="{{ route('buy.now', $product->sku) }}"
                                        class="btn btn-success w-full submit-btn border-0">Order Now</a>
                                @endif
                            </div>
                            <!-- Action Buttons -->
                            <a href="tel:01516137894" id="product-details-call-now-button"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto">
                                <div class="flex items-center">
                                    <div class="mr-2 button-icon"></div>
                                    <div>Call Now: +8801516137894</div>
                                </div>
                            </a>
                            <a href="https://api.whatsapp.com/send/?phone=8801516137894&text={{ urlencode('Hi Ek Online BD. I want to buy ' . $product->name . ' | Price: Tk ' . ($hasVariants ? $firstVariant->discount_price ?? $firstVariant->price : $product->discount_price ?? $product->price) . ' | Requested on ' . $currentDateTime . ' | ' . url()->current()) }}"
                                id="products-details-whatsapp-button"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto c-no-radius text-white"
                                style="background-color: rgba(16, 149, 136, 1);">
                                <div class="flex items-center">
                                    <div class="mr-2"></div>
                                    <div><strong>হোয়াটসঅ্যাপ অর্ডার</strong></div>
                                </div>
                            </a>
                            <a href="#" target="_blank" rel="noopener"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto !border-0"
                                id="products-details-messenger-button"
                                style="background-color: rgba(17, 139, 128, 1); color: rgba(255, 255, 255, 1);">
                                <div class="flex items-center">
                                    <div class="mr-2"></div>
                                    <div><strong>ম্যাসেঞ্জার অর্ডার</strong></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabset product-desc-tabs col-span-10">
            <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
            <label for="tab1">পন্যের বিবরণ</label>
            <div class="tab-panels text-left">
                <section id="marzen" class="tab-panel !pt-0">
                    <div class="text-md md:text-lg p-5 border border-[var(--primary-color)] border-t-0">
                        <div class="mt-4 desc mb-5">
                            <p>{{ $product->description }}</p>
                            @if ($product->warranty)
                                <p><strong>ওয়ারেন্টি:</strong> {{ $product->warranty }}</p>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.main-image');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const statusText = document.getElementById('status-text');
        const qtyInput = document.getElementById('qty');
        const cartQtyInput = document.getElementById('cart-qty');

        function changeImage(direction) {
            currentIndex += direction;
            if (currentIndex < 0) currentIndex = images.length - 1;
            if (currentIndex >= images.length) currentIndex = 0;
            updateImage();
        }

        function selectThumbnail(index) {
            currentIndex = index;
            updateImage();
        }

        function updateImage() {
            images.forEach((img, index) => {
                img.style.display = index === currentIndex ? 'block' : 'none';
                const zoomImg = img.nextElementSibling.querySelector('.zoom-image');
                zoomImg.style.display = index === currentIndex ? 'block' : 'none';
            });
            thumbnails.forEach((thumb, index) => {
                thumb.classList.toggle('active', index === currentIndex);
            });
        }

        // Initial setup
        if (images.length > 0) {
            updateImage();
        }

        // Quantity and variant controls
        const decreaseBtn = document.querySelector('.decrease-qty');
        const increaseBtn = document.querySelector('.increase-qty');
        const variantSelect = document.querySelector('#variant-select');
        const selectedVariantInput = document.querySelector('#selected-variant-id');
        const displayPriceWrap = document.querySelector('#display-price-wrap');

        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
                cartQtyInput.value = qtyInput.value;
            }
        });

        increaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            const maxStock = parseInt(qtyInput.max) || Infinity;
            if (value < maxStock) {
                qtyInput.value = value + 1;
                cartQtyInput.value = qtyInput.value;
            }
        });

        qtyInput.addEventListener('input', () => {
            const maxStock = parseInt(qtyInput.max) || Infinity;
            if (parseInt(qtyInput.value) > maxStock) {
                qtyInput.value = maxStock;
            }
            cartQtyInput.value = qtyInput.value;
        });

        if (variantSelect) {
            variantSelect.addEventListener('change', function() {
                const selectedVariantId = this.value;
                selectedVariantInput.value = selectedVariantId;

                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.dataset.price;
                const oldPrice = selectedOption.dataset.oldPrice;
                const discount = selectedOption.dataset.discount;
                const stock = selectedOption.dataset.stock;

                displayPriceWrap.innerHTML = `
                    <ins class="text-primary" id="display-price">Tk ${Number(price).toLocaleString()}</ins>
                    ${discount > 0 ? `
                            <del class="text-gray-400 font-normal ml-2" id="display-old-price">Tk ${Number(oldPrice).toLocaleString()}</del>
                            <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1" id="display-discount">${discount} Tk off</span>
                        ` : ''}
                `;

                // Update status text with new stock
                const statusSpan = statusText.querySelector('span');
                const currentStatus = stock > 0 ? 'In Stock' : 'Out of Stock';
                statusSpan.innerHTML = `${currentStatus} ${stock !== null ? `( ${stock} )` : ''}`;

                // Update quantity input max
                qtyInput.max = stock;
                if (parseInt(qtyInput.value) > stock) {
                    qtyInput.value = stock;
                    cartQtyInput.value = stock;
                }
            });
        }
    </script>
    <style>
        .main-image-container {
            position: relative;
            overflow: hidden;
            max-width: 100%;
            text-align: center;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }

        .flexImg {
            position: relative;
            display: inline-block;
            overflow: hidden;
            max-width: 400px;
        }

        .main-image,
        .zoom-image {
            width: 400px;
            height: 300px;
            object-fit: contain;
            transition: opacity 0.3s;
        }

        .zoomImg {
            position: absolute;
            top: 0;
            left: 0;
            width: 400px;
            height: 300px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .flexImg:hover .zoomImg {
            opacity: 1;
        }

        .thumbnail-container {
            display: flex;
            overflow-x: auto;
            padding: 5px 0;
        }

        .thumbnail {
            opacity: 0.6;
            transition: opacity 0.3s;
            width: 100px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            margin-right: 10px;
        }

        .thumbnail.active {
            opacity: 1;
            border: 2px solid #007bff;
        }
    </style>
@endsection
