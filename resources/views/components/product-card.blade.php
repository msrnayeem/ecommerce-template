<div
    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
    <div class="content-wrap relative h-full flex flex-col justify-between">
        <div class="relative h-full">
            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                @if ($product->discount_price && $product->price > $product->discount_price)
                    <strong
                        class="bg-primary font-bold text-[10px] flex items-center absolute left-3 gap-1 px-1 md:px-3 text-white rounded py-[3px] z-50">
                        {{ number_format($product->price - $product->discount_price) }}
                        <strong class="-ml-[2px]">TK Off</strong>
                    </strong>
                @endif
                <img src="{{ $product->images->first()->image_path }}"
                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                    loading="lazy" alt="{{ $product->name }}">
                <img src="{{ $product->images->skip(1)->first()->image_path ?? $product->images->first()->image_path }}"
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
                @if ($product->discount_price)
                    <del class="text-gray-500 text-sm">Tk {{ number_format($product->price) }}</del>
                    <ins class="mr-1 text-[16px]">Tk {{ number_format($product->discount_price) }}</ins>
                @else
                    <ins class="mr-1 text-[16px]">Tk {{ number_format($product->price) }}</ins>
                @endif
            </p>
        </div>
    </div>
    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1">
        <form action="{{ route('cart.add') }}" method="post" class="w-full">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            @if (isset($product->pivot->variant_id))
                <input type="hidden" name="variant_id" value="{{ $product->pivot->variant_id }}">
            @endif
            <button type="submit" class="btn border-0 btn-primary btn-sm w-full !rounded-none">Add To Cart</button>
        </form>
        <a href="{{ route('buy.now', $product->sku) }}"
            class="btn border-0 btn-primary btn-sm w-full !rounded-none">Order Now</a>
    </div>
</div>
