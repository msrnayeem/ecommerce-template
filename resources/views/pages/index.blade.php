@extends('layouts.app')

@section('content')
    <!-- Place all your existing HTML content here -->
    <div class="banner-section">
        <div class="container">
            <div id="banner-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <img src="{{ asset('assets/images/banner/banner-1.webp') }}" alt="Banner 1">
                        </li>
                        <li class="splide__slide">
                            <img src="{{ asset('assets/images/banner/banner-2.webp') }}" alt="Banner 2">
                        </li>
                        <li class="splide__slide">
                            <img src="{{ asset('assets/images/banner/banner-3.webp') }}" alt="Banner 3">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- slider -->
    <div id="homePageOfferOneSectionWrapper">
        <div id="offer1-products-list">
            <div class="container ">
                <div class="md:mt-16 mt-10 ">
                    <div class="flex justify-between items-center mb-4 md:mb-7">
                        <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">Hot Deals</h4>
                        <!-- promotions timer -->
                        <a href="#" class="btn btn-sm btn-primary">See All</a>
                    </div>
                </div>

                <div id="splide01" class="splide products-list">
                    <div class="splide__track">
                        <div class="splide__list">
                            <div class="splide__slide">
                                <div
                                    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                                    <div class="content-wrap relative h-full flex flex-col justify-between">
                                        <div class="relative h-full">
                                            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                                <strong
                                                    class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50">
                                                    100
                                                    <strong class="-ml-[2px]"> TK Off</strong>
                                                </strong>
                                                <!-- Primary Image -->
                                                <img src="assets/images/product/product-1.webp"
                                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">

                                                <!-- Secondary Image (optional) -->
                                                <img src="assets/images/product/product-1.1.webp"
                                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">
                                            </div>

                                        </div>
                                        <div class="p-3">
                                            <a href="products-details.html" class="uppercase stretched-link"
                                                tabindex="-1"></a>
                                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ
                                                গোলাপ ফুল লাইট
                                            </h4>
                                            <p class="md:text-lg text-md text-center">
                                                <del class="text-gray-500 text-sm">Tk 500</del>
                                                <ins class="mr-1 text-[16px]">Tk 400</ins>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                                        <form action="checkout.html" method="get" class="w-full">
                                            <button onclick="AddToCart(product?._id)" type="submit"
                                                class="btn border-0 btn-primary btn-sm w-full !rounded-none"
                                                tabindex="-1">অর্ডার
                                                করুন</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="splide__slide">
                                <div
                                    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                                    <div class="content-wrap relative h-full flex flex-col justify-between">
                                        <div class="relative h-full">
                                            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                                <strong
                                                    class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50">
                                                    100
                                                    <strong class="-ml-[2px]"> TK Off</strong>
                                                </strong>
                                                <!-- Primary Image -->
                                                <img src="assets/images/product/product-2.webp"
                                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">

                                                <!-- Secondary Image (optional) -->
                                                <img src="assets/images/product/product-2.1.webp"
                                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">
                                            </div>

                                        </div>
                                        <div class="p-3">
                                            <a href="products-details.html" class="uppercase stretched-link"
                                                tabindex="-1"></a>
                                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ
                                                গোলাপ ফুল লাইট
                                            </h4>
                                            <p class="md:text-lg text-md text-center">
                                                <del class="text-gray-500 text-sm">Tk 500</del>
                                                <ins class="mr-1 text-[16px]">Tk 400</ins>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                                        <form action="checkout.html" method="get" class="w-full">
                                            <button onclick="AddToCart(product?._id)" type="submit"
                                                class="btn border-0 btn-primary btn-sm w-full !rounded-none"
                                                tabindex="-1">অর্ডার
                                                করুন</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="splide__slide">
                                <div
                                    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                                    <div class="content-wrap relative h-full flex flex-col justify-between">
                                        <div class="relative h-full">
                                            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                                <strong
                                                    class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50">
                                                    100
                                                    <strong class="-ml-[2px]"> TK Off</strong>
                                                </strong>
                                                <!-- Primary Image -->
                                                <img src="assets/images/product/product-3.webp"
                                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">

                                                <!-- Secondary Image (optional) -->
                                                <img src="assets/images/product/product-3.1.webp"
                                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">
                                            </div>

                                        </div>
                                        <div class="p-3">
                                            <a href="products-details.html" class="uppercase stretched-link"
                                                tabindex="-1"></a>
                                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ
                                                গোলাপ ফুল লাইট
                                            </h4>
                                            <p class="md:text-lg text-md text-center">
                                                <del class="text-gray-500 text-sm">Tk 500</del>
                                                <ins class="mr-1 text-[16px]">Tk 400</ins>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                                        <form action="checkout.html" method="get" class="w-full">
                                            <button onclick="AddToCart(product?._id)" type="submit"
                                                class="btn border-0 btn-primary btn-sm w-full !rounded-none"
                                                tabindex="-1">অর্ডার
                                                করুন</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="splide__slide">
                                <div
                                    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                                    <div class="content-wrap relative h-full flex flex-col justify-between">
                                        <div class="relative h-full">
                                            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                                <strong
                                                    class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50">
                                                    100
                                                    <strong class="-ml-[2px]"> TK Off</strong>
                                                </strong>
                                                <!-- Primary Image -->
                                                <img src="assets/images/product/product-4.webp"
                                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">

                                                <!-- Secondary Image (optional) -->
                                                <img src="assets/images/product/product-4.1.webp"
                                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                                    loading="lazy" alt="৮০ পিছ গোলাপ ফুল লাইট">
                                            </div>

                                        </div>
                                        <div class="p-3">
                                            <a href="products-details.html" class="uppercase stretched-link"
                                                tabindex="-1"></a>
                                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ
                                                গোলাপ ফুল লাইট
                                            </h4>
                                            <p class="md:text-lg text-md text-center">
                                                <del class="text-gray-500 text-sm">Tk 500</del>
                                                <ins class="mr-1 text-[16px]">Tk 400</ins>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                                        <form action="checkout.html" method="get" class="w-full">
                                            <button onclick="AddToCart(product?._id)" type="submit"
                                                class="btn border-0 btn-primary btn-sm w-full !rounded-none"
                                                tabindex="-1">অর্ডার
                                                করুন</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- products-list-by-category -->
    <div id="products-list-by-category">
        <div class="container">
            <div class="md:mt-16 mt-10">
                <div class="flex justify-between items-center mb-4 md:mb-7">
                    <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">Premium Light</h4>

                    <!-- promotions timer -->
                    <a href="categories.html" class="btn btn-sm btn-primary">See All</a>
                </div>
            </div>

            <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                <div
                    class="product-grid h-full flex flex-col justify-between border border-opacity-1 border-gray-200 hover:border-primary p-3 two-img-effect">
                    <div class="content-wrap relative h-full flex flex-col justify-between">
                        <div class="relative h-full">
                            <div class="img-wrap relative aspect-[3/4] overflow-hidden">
                                <strong
                                    class="bg-primary font-bold text-[10px] flex items-center absolute left-3  gap-1 px-1 md:px-3 text-white rounded  py-[3px] z-50"
                                    style="">
                                    200
                                    <strong class="-ml-[2px]">TK Off</strong>
                                </strong>
                                <!-- Primary Image -->
                                <img src="assets/images/product/product-6.webp"
                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                    loading="lazy" alt="Cute Table Lamp Rechargeable">

                                <!-- Secondary Image (optional) -->
                                <img src="assets/images/product/product-6.1.webp"
                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                    loading="lazy" alt="Cute Table Lamp Rechargeable">
                            </div>

                        </div>
                        <div class="p-3">
                            <a href="products-details.html" class="uppercase stretched-link"></a>
                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">Cute Table Lamp
                                Rechargeable</h4>
                            <p class="md:text-lg text-md text-center">
                                <del class="text-gray-500 text-sm">Tk 799</del>
                                <ins class="mr-1 text-[16px]">Tk 599</ins>
                            </p>
                        </div>
                    </div>

                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                        <a href="products-details.html" class="btn border-0 btn-success btn-sm !rounded-none"
                            style=" ">অর্ডার করুন</a>
                    </div>
                </div>

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
                                <img src="assets/images/product/product-8.webp"
                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                    loading="lazy" alt="16 color Rose Diamond Lamp">

                                <!-- Secondary Image (optional) -->
                                <img src="assets/images/product/product-8.1.webp"
                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                    loading="lazy" alt="16 color Rose Diamond Lamp">
                            </div>

                        </div>
                        <div class="p-3">
                            <a href="products-details.html" class="uppercase stretched-link"></a>
                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">16 color Rose Diamond Lamp
                            </h4>
                            <p class="md:text-lg text-md text-center">
                                <del class="text-gray-500 text-sm">Tk 1199</del>
                                <ins class="mr-1 text-[16px]">Tk 899</ins>
                            </p>

                        </div>
                    </div>
                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                        <form action="checkout.html" method="get" class="w-full">
                            <button onclick="AddToCart(product?._id)" type="submit"
                                class="btn border-0 btn-primary btn-sm w-full !rounded-none" style="">অর্ডার
                                করুন</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="products-list-by-category">
        <div class="container">
            <div class="md:mt-16 mt-10">
                <div class="flex justify-between items-center mb-4 md:mb-7">
                    <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">Metal Light</h4>
                    <!-- promotions timer -->
                    <a href="categories.html" class="btn btn-sm btn-primary">See All</a>
                </div>
            </div>

            <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                <!-- item -->
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
                                <img src="assets/images/product/product-8.webp"
                                    class="primary-img w-full h-full object-contain absolute inset-0 transition-all duration-300"
                                    loading="lazy" alt="16 color Rose Diamond Lamp">

                                <!-- Secondary Image (optional) -->
                                <img src="assets/images/product/product-8.1.webp"
                                    class="secondary-img w-full h-full object-contain absolute inset-0 opacity-0 transition-all duration-300"
                                    loading="lazy" alt="16 color Rose Diamond Lamp">
                            </div>

                        </div>
                        <div class="p-3">
                            <a href="products-details.html" class="uppercase stretched-link"></a>
                            <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">16 color Rose Diamond Lamp
                            </h4>
                            <p class="md:text-lg text-md text-center">
                                <del class="text-gray-500 text-sm">Tk 1199</del>
                                <ins class="mr-1 text-[16px]">Tk 899</ins>
                            </p>

                        </div>
                    </div>
                    <div class="form-cart-wrap grid sm:grid-cols-1 grid-cols-1 sm:gap-2 gap-1 ">
                        <form action="checkout.html" method="get" class="w-full">
                            <button onclick="AddToCart(product?._id)" type="submit"
                                class="btn border-0 btn-primary btn-sm w-full !rounded-none" style="">অর্ডার
                                করুন</button>
                        </form>
                    </div>
                </div>
                <!-- item -->
            </div>


        </div>
    </div>
@endsection
