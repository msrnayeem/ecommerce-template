@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Home</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2"><a
                        href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                </li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="px-1 md:px-2">{{ $product->name }}</li>
            </ol>
            <ol class="flex items-center">
                <li><i class="bi bi-chevron-left"></i></li>
                <li class="px-1 md:px-2"><a href="{{ route('home') }}" class="">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="product-details-wrapper container mx-auto md:py-5 relative z-[90]">
        <div class="stx-product-details-container grid grid-cols-10 md:grid-cols-10 gap-2 md:gap-7 mb-6">
            <!-- Product Images -->
            <div
                class="stx-product-details-image-container lg:col-span-5 md:col-span-5 col-span-10 product-details-image mt-3">
                <div class="border p-0 md:p-5" id="image-gallery">
                    <!-- Main Slider -->
                    <div id="main-slider" class="splide main-image">
                        <div class="splide__track">
                            <div class="splide__list" id="main-image-list">
                                @forelse($product->productImages as $image)
                                    <div class="splide__slide imageZoom"
                                        data-variant-id="{{ $image->variant_id ?? 'none' }}">
                                        <div class="flexImg">
                                            <img src="{{ $image->image_path }}" alt="{{ $image->alt_text }}"
                                                class="main-image">
                                            <div class="zoomImg">
                                                <img src="{{ $image->image_path }}" alt="{{ $image->alt_text }}"
                                                    class="zoom-image">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="splide__slide imageZoom" data-variant-id="none">
                                        <div class="flexImg">
                                            <img src="https://via.placeholder.com/150" alt="No image" class="main-image">
                                            <div class="zoomImg">
                                                <img src="https://via.placeholder.com/150" alt="No image"
                                                    class="zoom-image">
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- Thumbnail Slider -->
                    <div id="thumbnail-slider" class="splide mt-5">
                        <div class="splide__track">
                            <div class="splide__list" id="thumbnail-image-list">
                                @forelse($product->productImages as $image)
                                    <div class="splide__slide" data-variant-id="{{ $image->variant_id ?? 'none' }}">
                                        <img src="{{ $image->image_path }}" alt="{{ $image->alt_text }}"
                                            class="main-image">
                                    </div>
                                @empty
                                    <div class="splide__slide" data-variant-id="none">
                                        <img src="https://via.placeholder.com/150" alt="No image" class="main-image">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hidden input to store all images data -->
                <input type="hidden" id="product-images-data"
                    value="{{ json_encode(
                        $product->productImages->map(function ($image) {
                                return [
                                    'id' => $image->id,
                                    'image_path' => $image->image_path,
                                    'alt_text' => $image->alt_text,
                                    'variant_id' => $image->variant_id ?? 'none',
                                ];
                            })->toArray(),
                    ) }}">
            </div>

            <!-- Product Info -->
            <div class="lg:col-span-5 md:col-span-5 col-span-10 product-details-content mt-3">
                <div class="md:p-5 p-0 md:border">
                    <div class="stx-product-details-product-info">
                        <h2 class="stx-product-details-product-title text-xl md:text-2xl font-semibold">
                            {{ $product->name }}</h2>
                        <div class="stx-product-details-product-sku-container flex justify-between">
                            <div class="stx-product-details-product-sku">
                                <strong class="text-lg uppercase">SKU:</strong> {{ $product->sku }}
                            </div>
                            <!-- Social Share -->
                            <div class="social-share mb-2">
                                <ul class="flex items-center">
                                    <li class="mr-2">
                                        <a style="padding-top: 1.8px;"
                                            class="bg-secondary hover:text-primary inline-block w-7 h-7 text-center leading-7 rounded-full"
                                            target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            rel="noopener noreferrer nofollow">
                                            <i class="bi bi-facebook text-lg"></i>
                                        </a>
                                    </li>
                                    <li class="mr-2">
                                        <a style="padding-top: 1.8px;"
                                            class="bg-secondary inline-block w-7 h-7 text-center leading-7 rounded-full cursor-pointer"
                                            target="_blank"
                                            href="https://api.whatsapp.com/send?phone=8801516137894&text={{ urlencode('Hi Ek Online BD. I want to buy ' . $product->name . ' | Price: Tk ' . ($product->discount_price ?? $product->price) . ' | ' . url()->current()) }}"
                                            rel="noopener noreferrer nofollow">
                                            <i class="bi bi-whatsapp text-lg"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Price and Variations -->
                        <div class="stx-product-details-product-price-container flex items-center mb-2">
                            <strong class="stx-product-details-product-price-title text-lg uppercase">PRICE:</strong>
                            <span class="text-lg md:text-xl ml-1 font-bold" id="display-price-wrap">
                                @php
                                    $hasVariants = $product->productVariants->count() > 0;
                                    $firstVariant = $hasVariants ? $product->productVariants->first() : null;
                                    $variantPrice = $firstVariant
                                        ? $firstVariant->discount_price ?? $firstVariant->price
                                        : null;
                                    $variantOldPrice = $firstVariant ? $firstVariant->price : null;
                                @endphp
                                <ins class="text-primary" id="display-price">
                                    Tk
                                    {{ $hasVariants ? number_format($variantPrice) : number_format($product->discount_price ?? $product->price) }}
                                </ins>
                                @if ($hasVariants && $firstVariant && $firstVariant->discount_price)
                                    <del class="text-gray-400 font-normal ml-2" id="display-old-price">
                                        Tk {{ number_format($variantOldPrice) }}
                                    </del>
                                    <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1"
                                        id="display-discount">
                                        {{ number_format($variantOldPrice - $firstVariant->discount_price) }} Tk off
                                    </span>
                                @elseif(!$hasVariants && $product->discount_price)
                                    <del class="text-gray-400 font-normal ml-2" id="display-old-price">
                                        Tk {{ number_format($product->price) }}
                                    </del>
                                    <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1"
                                        id="display-discount">
                                        {{ number_format($product->price - $product->discount_price) }} Tk off
                                    </span>
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
                                            data-discount="{{ $variant->discount_price ? number_format($variant->price - $variant->discount_price) : 0 }}">
                                            {{ $variant->variant_name }}: {{ $variant->variant_value }}
                                            (Tk {{ number_format($variant->discount_price ?? $variant->price) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <strong class="stx-product-details-product-varations-container-4-item-title text-lg uppercase">
                            Status: <span class="text-success capitalize">
                                @if ($product->getEffectiveStock() > 0)
                                    In Stock
                                @else
                                    Out of Stock
                                @endif
                            </span>
                        </strong>

                        <div>
                            <div class="md:block flex-col items-center md:pt-0 pt-2">
                                <div class="quantity-wrap flex md:py-3 md:mr-0 mr-3 mb-2">
                                    <label for="qty"
                                        class="text-lg uppercase md:block hidden font-bold mt-2 mr-4">Quantity</label>
                                    <span
                                        class="decrease-qty md:px-3 px-4 md:py-2 py-[6px] cursor-pointer qty-button border border-gray-200 border-solid">-</span>
                                    <input type="number" id="qty"
                                        class="w-12 text-center qty-button md:text-lg text-sm font-bold border"
                                        name="qty" min="1" value="1"
                                        oninput="this.value = Math.floor(this.value)">
                                    <span
                                        class="increase-qty md:px-3 px-4 md:py-2 py-[6px] cursor-pointer qty-button border border-gray-200 border-solid">+</span>
                                </div>
                            </div>
                            <hr class="mt-3 md:block hidden">
                            <div class="md:mt-3 flex-1 order-now-wrap">
                                <div class="grid grid-cols-2 gap-2 flex form-cart-wrap align-items-center mb-1">
                                    <!-- Add to Cart Button -->
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
                                    <!-- Order Now Button -->
                                    @if ($product->productVariants->count())
                                        <a href="{{ route('buy.now', ['sku' => $product->sku, 'variant' => $product->productVariants->first()->id]) }}"
                                            class="btn btn-success w-full submit-btn border-0">Order Now </a>
                                    @else
                                        <a href="{{ route('buy.now', $product->sku) }}"
                                            class="btn btn-success w-full submit-btn border-0">Order Now </a>
                                    @endif
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <a href="tel:01516137894" id="product-details-cal-now-button"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto">
                                <div class="flex items-center">
                                    <div class="mr-2 button-icon"></div>
                                    <div>Call Now: +8801516137894</div>
                                </div>
                            </a>
                            <a href="https://api.whatsapp.com/send/?phone=8801516137894&text={{ urlencode('Hi Ek Online BD. I want to buy ' . $product->name . ' | Price: Tk ' . ($product->discount_price ?? $product->price) . ' | ' . url()->current()) }}"
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
                                id="products-details-messanger-button"
                                style="background-color: rgba(17, 139, 128, 1); color: rgba(255, 255, 255, 1);">
                                <div class="flex items-center">
                                    <div class="mr-2"></div>
                                    <div><strong>ম্যাসেঞ্জার অর্ডার</strong></div>
                                </div>
                            </a>
                            <!-- Product Notes -->
                            <div class="stx-product-details-product-notes rounded-md p-4 alert-info mb-5 mt-5 text-xs">
                                <h3>আমাদের প্রতিটা ৫০০টাকার নিচের পন্য ১মাস ওয়ারেন্টি এবং ৫০০টাকার উপরের পন্য ৩মাস ওয়ারেন্টি
                                </h3>
                                <p><span class="marker"><strong>যে কোন ২টি পন্য কিনলে ডেলিভারি চার্জ একদম
                                            ফ্রি</strong></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="tabset product-desc-tabs col-span-10">
            <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
            <label for="tab1">পন্যের বিবরণ</label>
            <div class="tab-panels text-left">
                <section id="marzen" class="tab-panel !pt-0">
                    <div class="text-md md:text-lg p-5 border border-[var(--primary-color)] border-t-0">
                        <div class="mt-4">
                            <div class="desc mb-5">
                                <p>{{ $product->description }}</p>
                                @if ($product->warranty)
                                    <p><strong>ওয়ারেন্টি:</strong> {{ $product->warranty }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <div class="load-section" data-endpoint="/related-products">
        <div class="container">
            <div class="md:mt-16 mt-10">
                <div class="text-center mb-4 md:mb-7">
                    <h4 class="uppercase text-lg md:text-3xl md:tracking-widest font-bold">Related Products</h4>
                </div>
            </div>
            <div id="splide02" class="splide products-list similar-products">
                <div class="splide__track">
                    <div class="splide__list">
                        @forelse($relatedProducts as $relatedProduct)
                            <div class="splide__slide">
                                <x-product-card :product="$relatedProduct" />
                            </div>
                        @empty
                            <div class="splide__slide">
                                <p class="text-gray-600 text-center">No related products found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Splide sliders
            const mainSlider = new Splide('#main-slider', {
                type: 'loop',
                perPage: 1,
                arrows: true,
                pagination: false,
            }).mount();

            const thumbnailSlider = new Splide('#thumbnail-slider', {
                fixedWidth: 100,
                fixedHeight: 60,
                gap: 10,
                rewind: true,
                pagination: false,
                isNavigation: true,
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 44
                    },
                },
            }).mount();

            mainSlider.sync(thumbnailSlider);

            // Quantity controls
            const decreaseBtn = document.querySelector('.decrease-qty');
            const increaseBtn = document.querySelector('.increase-qty');
            const qtyInput = document.querySelector('#qty');
            const cartQtyInput = document.querySelector('#cart-qty');
            const variantSelect = document.querySelector('#variant-select');
            const selectedVariantInput = document.querySelector('#selected-variant-id');
            const imagesData = JSON.parse(document.querySelector('#product-images-data').value);
            const displayPriceWrap = document.querySelector('#display-price-wrap');

            // Quantity controls
            decreaseBtn.addEventListener('click', () => {
                let value = parseInt(qtyInput.value);
                if (value > 1) {
                    qtyInput.value = value - 1;
                    cartQtyInput.value = qtyInput.value;
                }
            });

            increaseBtn.addEventListener('click', () => {
                let value = parseInt(qtyInput.value);
                qtyInput.value = value + 1;
                cartQtyInput.value = qtyInput.value;
            });

            qtyInput.addEventListener('input', () => {
                cartQtyInput.value = qtyInput.value;
            });

            // Variant selection and image update
            if (variantSelect) {
                variantSelect.addEventListener('change', function() {
                    const selectedVariantId = this.value;
                    selectedVariantInput.value = selectedVariantId;

                    // Find the first image for the selected variant
                    let selectedImage = imagesData.find(image => image.variant_id === selectedVariantId);
                    // Fallback to first product-level image if no variant-specific image
                    if (!selectedImage) {
                        selectedImage = imagesData.find(image => image.variant_id === 'none');
                    }
                    // Fallback to placeholder if no images
                    if (!selectedImage) {
                        selectedImage = {
                            image_path: 'https://via.placeholder.com/150',
                            alt_text: 'No image',
                            variant_id: 'none'
                        };
                    }

                    // Update main slider to show the selected image
                    const imageIndex = imagesData.findIndex(image =>
                        image.image_path === selectedImage.image_path &&
                        image.alt_text === selectedImage.alt_text &&
                        image.variant_id === selectedImage.variant_id
                    );
                    mainSlider.go(imageIndex !== -1 ? imageIndex : 0);

                    // Update price
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.dataset.price;
                    const oldPrice = selectedOption.dataset.oldPrice;
                    const discount = selectedOption.dataset.discount;

                    displayPriceWrap.innerHTML = `
                        <ins class="text-primary" id="display-price">Tk ${Number(price).toLocaleString()}</ins>
                        ${discount > 0 ? `
                                                                                                        <del class="text-gray-400 font-normal ml-2" id="display-old-price">Tk ${Number(oldPrice).toLocaleString()}</del>
                                                                                                        <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1" id="display-discount">${discount} Tk off</span>
                                                                                                    ` : ''}
                    `;
                });
            }
        });
    </script>
@endsection
