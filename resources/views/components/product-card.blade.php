@php
    if ($product->variants->count()) {
        $lowestVariant = $product->variants
            ->sortBy(function ($variant) {
                return $variant->discount_price ?? $variant->price;
            })
            ->first();
        $displayPrice = $lowestVariant->discount_price ?? $lowestVariant->price;
        $originalPrice = $lowestVariant->price;
        $discountAmount =
            $lowestVariant->discount_price && $lowestVariant->discount_price < $lowestVariant->price
                ? $lowestVariant->price - $lowestVariant->discount_price
                : null;
        $variantId = $lowestVariant->id;
    } else {
        $displayPrice = $product->discount_price ?? $product->price;
        $originalPrice = $product->price;
        $discountAmount =
            $product->discount_price && $product->discount_price < $product->price
                ? $product->price - $product->discount_price
                : null;
        $variantId = null;
    }
@endphp

<div
    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
    <div class="content-wrap relative h-full flex flex-col justify-between">
        <div class="relative h-full">
            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                @if ($discountAmount)
                    <strong
                        class="bg-primary font-bold text-[10px] flex items-center absolute left-3 gap-1 px-1 md:px-3 text-white rounded py-[3px] z-50">
                        {{ number_format($discountAmount) }}
                        <strong class="-ml-[2px]">TK Off</strong>
                    </strong>
                @endif
                <img src="{{ $product->images->first()->image_path ?? 'https://via.placeholder.com/150' }}"
                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                    loading="lazy" alt="{{ $product->name }}">
                <img src="{{ $product->images->skip(1)->first()->image_path ?? ($product->images->first()->image_path ?? 'https://via.placeholder.com/150') }}"
                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                    loading="lazy" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="p-3">
            <a href="{{ route('products.show', $product->sku) }}" class="uppercase stretched-link"></a>
            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">
                {{ $product->name }}
            </h4>
            <p class="md:text-lg text-md text-center">
                @if ($discountAmount)
                    <del class="text-gray-500 text-sm">Tk {{ number_format($originalPrice) }}</del>
                    <ins class="mr-1 text-[16px]">Tk {{ number_format($displayPrice) }}</ins>
                @else
                    <ins class="mr-1 text-[16px]">Tk {{ number_format($displayPrice) }}</ins>
                @endif
            </p>
        </div>
    </div>
    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1">
        <form action="{{ route('cart.add') }}" method="post" class="w-full">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            @if ($variantId)
                <input type="hidden" name="variant_id" value="{{ $variantId }}">
            @endif
            <button type="submit" class="btn border-0 btn-primary btn-sm w-full !rounded-none">Add To Cart</button>
        </form>
        <a href="{{ route('buy.now', ['sku' => $product->sku, 'variant' => $variantId]) }}"
            class="btn border-0 btn-primary btn-sm w-full !rounded-none">Order Now </a>
    </div>
</div>
