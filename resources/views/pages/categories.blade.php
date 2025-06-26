@extends('layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Categories', 'url' => route('categories')],
            ['label' => 'Premium Light', 'url' => ''],
        ];
        $backUrl = route('home');
    @endphp

    <x-breadcrumb :breadcrumbs="$breadcrumbs" :backUrl="$backUrl" />

    <section class="py-4">
        <div class="container">
            <div>
                <!-- Another Page Sub Heading -->
                <div class="wh-sub-heading text-center">
                    <!-- sorting by price -->
                    <div class="flex flex-wrap justify-between items-center">
                        <h2 class="uppercase lg:text-5xl md:text-3xl text-xl font-bold text-black">
                            Premium Light
                        </h2>
                    </div>
                </div>
            </div>
            <div class="products-container grid xl:grid-cols-4 md:grid-cols-2 grid-cols-2 gap-2 md:gap-5">
                @for ($i = 0; $i < 5; $i++)
                    <div
                        class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                        <div class="content-wrap relative h-full flex flex-col justify-between">
                            <div class="relative h-full">
                                <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                    <strong
                                        class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50"
                                        style="">
                                        300
                                        <strong class="-ml-[2px]">TKOff</strong>
                                    </strong>
                                    <span
                                        class="free-shipping-badge flex items-center absolute right-[0px] top-0 !text-[10px] gap-1 px-2 md:px-3 py-1 z-50"
                                        style="">
                                        ৳ Free Shipping
                                    </span>
                                    <!-- Primary Image -->
                                    <img src="{{ asset('assets/images/product/product-8.webp') }}"
                                        class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                        loading="lazy" alt="16 color Rose Diamond Lamp">

                                    <!-- Secondary Image (optional) -->
                                    <img src="{{ asset('assets/images/product/product-8.1.webp') }}"
                                        class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                        loading="lazy" alt="16 color Rose Diamond Lamp">
                                </div>
                            </div>
                            <div class="p-3">
                                <a href="{{ route('products-details') }}" class="uppercase stretched-link"></a>
                                <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">16 color Rose
                                    Diamond Lamp</h4>
                                <p class="md:text-lg text-md text-center">
                                    <del class="text-gray-500 text-sm">Tk 1199</del>
                                    <ins class="mr-1 text-[16px]">Tk 899</ins>
                                </p>
                            </div>
                        </div>
                        <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                            <form action="../checkout.html" method="get" class="w-full">
                                <button onclick="AddToCart(product?._id)" type="submit"
                                    class="btn border-0 btn-primary btn-sm w-full !rounded-none" style="">অর্ডার
                                    করুন</button>
                            </form>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
