@extends('layouts.app')

@section('content')
    <!-- description tabs css -->
    <style>
        .tabset>input[type="radio"] {
            position: absolute;
            left: -200vw;
        }

        .tabset .tab-panel {
            display: none;
        }

        .tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
        .tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
        .tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
        .tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
        .tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
        .tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6) {
            display: block;
        }

        .tabset>label {
            position: relative;
            display: inline-block;
            padding: 15px 15px 25px;
            border: 1px solid transparent;
            border-bottom: 0;
            cursor: pointer;
            font-weight: 600;
            font-size: 30px;
        }

        .tabset>label:hover,
        .tabset>input:focus+label {
            color: var(--primary-color);
        }

        .tabset>input:checked+label {
            border-color: var(--primary-color);
            border-bottom: 1px solid #fff;
            margin-bottom: -1px;
        }

        .tab-panel {
            padding: 30px 0;
            border-top: 1px solid var(--primary-color);
        }

        .product-desc-tabs {
            box-shadow: rgb(14 30 37 / 12%) 0px 2px 4px 0px, rgb(14 30 37 / 32%) 0px 2px 16px 0px;
            padding: 20px;
            border-radius: 5px;
            text-align: left;
        }

        .product-desc-tabs h1 {
            font-size: 50px;
        }

        .product-desc-tabs h2 {
            font-size: 40px;
        }

        .product-desc-tabs h3 {
            font-size: 30px;
        }

        .product-desc-tabs menu,
        .product-desc-tabs ol,
        .product-desc-tabs ul {
            list-style: inherit;
            padding-left: 20px;
        }

        @media(max-width: 768px) {
            .tabset>label {
                padding: 8px 8px 10px;
                font-size: 13px;
            }

            .tab-panel {
                padding: 10px 0;
            }

            .product-desc-tabs {
                box-shadow: rgb(14 30 37 / 12%) 0px 0px 0px 0px, rgb(14 30 37 / 32%) 0px 3px 2px 0px;
                padding: 15px;
            }
        }
    </style>


    <!-- breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="index.html" class="">Home</a></li>
                <li>
                    <i class="bi bi-chevron-right"></i>
                </li>
                <li class="px-1 md:px-2">28LED Snowball Light</li>
            </ol>
            <ol class="flex items-center">
                <li>
                    <i class="bi bi-chevron-left"></i>
                </li>
                <li class="px-1 md:px-2"><a href="index.html" class="">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="product-details-wrapper container mx-auto md:py-5 relative z-[90]">
        <div class="stx-product-details-container grid grid-cols-10 md:grid-cols-10 gap-2 md:gap-7 mb-6">
            <div
                class="stx-product-details-image-container lg:col-span-5 md:col-span-5 col-span-10  product-details-image mt-3">
                <div class="border p-0 md:p-5" id="image-gallery">
                    <div id="main-slider" class="splide main-image">
                        <div class="splide__track">
                            <div class="splide__list">
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-1.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-1.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-2.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-2.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-3.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-3.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-4.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-4.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-5.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-5.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-6.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-6.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-7.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-7.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                                <div class="splide__slide imageZoom">
                                    <div class="flexImg">
                                        <img src="assets/images/product/product-8.webp"
                                            alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                            style="">
                                        <div class="zoomImg">
                                            <img src="assets/images/product/product-8.webp"
                                                alt="28LED Snowball Light Multicolor - Image 1" class="zoom-image"
                                                style="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="thumbnail-slider" class="splide mt-5 ">
                        <div class="splide__track">
                            <div class="splide__list">
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-1.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-2.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-3.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-4.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-5.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>
                                <div class="splide__slide">
                                    <img src="assets/images/product/product-6.webp"
                                        alt="28LED Snowball Light Multicolor - Image 1" class="main-image"
                                        style="">
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- product Info -->
            <div class="lg:col-span-5 md:col-span-5 col-span-10  product-details-content mt-3">
                <div class="md:p-5 p-0 md:border">
                    <div class="stx-product-details-product-info">
                        <h2 class="stx-product-details-product-title text-xl md:text-2xl font-semibold">
                            28LED Snowball Light Multicolor</h2>
                        <div class="stx-product-details-product-sku-container flex justify-between">
                            <div class="stx-product-details-product-sku"><strong class="text-lg uppercase">SKU:</strong>
                                SKU-00292
                            </div>
                            <!-- Social Share -->
                            <div class="social-share mb-2">
                                <ul class="flex items-center">
                                    <!-- Inside your EJS file -->
                                    <li class="mr-2">
                                        <a style="padding-top: 1.8px;"
                                            class="bg-secondary hover:text-primary inline-block w-7 h-7 text-center leading-7 rounded-full"
                                            target="_blank" href="#" rel="noopener noreferrer nofollow">
                                            <i class="bi bi-facebook text-lg"></i>
                                        </a>
                                    </li>
                                    <li class="mr-2">
                                        <a style="padding-top: 1.8px;"
                                            class="bg-secondary inline-block w-7 h-7 text-center leading-7 rounded-full cursor-pointer"
                                            target="_blank" href="#" rel="noopener noreferrer nofollow">
                                            <i class="bi bi-whatsapp text-lg"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- price and varations -->
                        <div class="stx-product-details-product-price-container flex items-center">
                            <strong class="stx-product-details-product-price-title text-lg uppercase">PRICE:</strong>
                            <span class="text-lg md:text-xl ml-1 font-bold">
                                <ins class="text-primary">
                                    <span>Tk <span x-text="$store.store.data.price">299</span></span>
                                </ins>
                                <del class="text-gray-400 font-normal ml-2">Tk <span>349</span></del>
                                <!-- discount percentage -->
                                <span class="discount-percent ml-2 bg-orange-500 z-10 text-xs text-white px-3 py-1"
                                    style="">50Tk
                                    off</span>
                            </span>
                        </div>

                        <strong
                            class="stx-product-details-product-varations-container-4-item-title text-lg uppercase">Status:
                            <span class="text-success capitalize">In Stock </span>
                        </strong>

                        <div class="">
                            <div class="md:block flex-col items-center md:pt-0 pt-2">
                                <div class="quantity-wrap flex md:py-3 md:mr-0 mr-3 mb-2">
                                    <label for="qty"
                                        class="text-lg uppercase md:block hidden font-bold mt-2 mr-4">Quantity</label>
                                    <span
                                        class="decrease-qty md:px-3 px-4 md:py-2  py-[6px] cursor-pointer qty-button border border-gray-200 border-solid">-</span>
                                    <input type="number" id="qty"
                                        class="w-12 text-center qty-button md:text-lg text-sm font-bold border"
                                        name="qty" min="1" value="1"
                                        oninput="this.value = Math.floor(this.value)">
                                    <span
                                        class="increase-qty md:px-3 px-4 md:py-2 py-[6px] cursor-pointer qty-button border border border-gray-200 border-solid">+</span>
                                </div>
                            </div>
                            <hr class="mt-3 md:block hidden">
                            <div class="md:mt-3 flex-1 order-now-wrap" :class="{ 'disable': $store.store.data.qty == 0 }">
                                <div class="grid grid-cols-2 gap-2 flex form-cart-wrap align-items-center mb-1">
                                    <!-- Add to cart Button -->
                                    <button type="submit" class="btn btn-primary w-full submit-btn border-0"
                                        style="">
                                        কার্ড এ যুক্ত করুন
                                    </button>
                                    <!-- order now Button -->
                                    {{-- <button type="submit" class="btn btn-success w-full submit-btn border-0"
                                        style="">
                                        <span>অর্ডার করুন</span>
                                    </button> --}}
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-success w-full submit-btn border-0">অর্ডার করুন</a>
                                </div>
                            </div>
                            <!-- Action buttons -->
                            <a href="tel:01516137894" id="product-details-cal-now-button"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto">
                                <div class="flex items-center">
                                    <div class="mr-2 button-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem"
                                            fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                            <path
                                                d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        Call Now: +8801516137894
                                    </div>
                                </div>
                            </a>
                            <a href="https://api.whatsapp.com/send/?phone=8801516137894&amp;text=Hi%20Ek%20Online%20BD.%20%20I%20Want%20To%20Buy%2028LED%20Snowball%20Light%20Multicolor%20%7C%20%20Price:%20299Tk%20%20%7C%20https://www.ekonlinebd.com/products/28led-snowball-light-multicolor"
                                id="products-details-whatsapp-button"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto c-no-radius text-white"
                                style="background-color: rgba(16, 149, 136, 1);">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem"
                                            fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                            <path
                                                d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>হোয়াটসঅ্যাপ অর্ডার</strong>
                                    </div>
                                </div>
                            </a>

                            <a href="#" target="_blank" rel="noopener"
                                class="btn btn-success btn-block mt-2 text-xl py-2 !h-auto !border-0"
                                id="products-details-messanger-button"
                                style="background-color: rgba(17, 139, 128, 1); color: rgba(255, 255, 255, 1);">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem"
                                            fill="currentColor" class="bi bi-messenger" viewBox="0 0 16 16">
                                            <path
                                                d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.64.64 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.64.64 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76m5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>ম্যাসেঞ্জার অর্ডার</strong>
                                    </div>
                                </div>
                            </a>

                            <!-- product notes -->
                            <div class="stx-product-details-product-notes rounded-md p-4 alert-info mb-5 mt-5 text-xs">
                                <h3>আমাদের প্রতিটা ৫০০টাকার নিচের পন্য ১মাস ওয়ারেন্টি এবং ৫০০টাকার উপরের পন্য ৩মাস ওয়ারেন্টি
                                </h3>
                                <p><span class="marker"><strong>যে কোন ২টি পন্য কিনলে ডেলিভারি চার্য একদম
                                            ফ্রি</strong></span></p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- Description -->
        <div class="tabset product-desc-tabs col-span-10">
            <!-- Tab 1 -->

            <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked="">
            <label for="tab1">পন্যের বিবরণ</label>

            <div class="tab-panels text-left">
                <section id="marzen" class="tab-panel !pt-0">
                    <div class="text-md md:text-lg p-5 border border-[var(--primary-color)] border-t-0">
                        <div class="mt-4">
                            <div class="desc mb-5">
                                <p>🌟 Northern Light Music Starry Projection Light 🌟</p>
                                <p>✨ একটি অদ্বিতীয় আলোর ও সঙ্গীতের অভিজ্ঞতা!</p>
                                <p>🌻 বিশেষত্ব:</p>
                                <p>টার্চ কন্ট্রোল সিস্টেম: সহজেই আলো নিয়ন্ত্রণ করতে পারবেন</p>
                                <p>USB সিস্টেম: সহজে চার্জ করা যাবে এবং যেকোনো জায়গায় ব্যবহারযোগ্য</p>
                                <p>গানের সাথে আলো জ্বলবে: আপনার পছন্দের সঙ্গীতের সঙ্গে সিঙ্ক হয়ে আলো পরিবর্তিত হবে, তৈরি
                                    করবে এক
                                    অসাধারণ মিউজিক্যাল অটো লাইট শো</p>
                                <p>স্টার প্রজেকশন: রাতের আকাশের মতো এক সুন্দর আলোর প্রক্ষেপণ</p>
                                <p>আলাদা অভিজ্ঞতা: গান এবং আলো একসঙ্গে আপনার পরিবেশে নতুন রোমাঞ্চ নিয়ে আসবে</p>
                                <p>🌿 Northern Light Music Starry Projection Light দিয়ে আপনার ঘরকে রঙিন ও সঙ্গীতময় করুন! ✨
                                </p>
                                <p><br></p>
                                <p>#Lighting #MusicLights #StarryProjection #TouchControl #USBSystem #MusicAndLights
                                    #HomeDecor
                                    #AmbintLightn</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Related Product   -->
    <div class="load-section" data-endpoint="/related-products">
        <div class="container ">
            <div class="md:mt-16 mt-10 ">
                <div class="text-center mb-4 md:mb-7">
                    <h4 class="uppercase text-lg md:text-3xl md:tracking-widest font-bold">Related Products</h4>
                </div>
            </div>
            <!-- slider -->
            <div id="splide02" class="splide products-list similar-products">
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
                                        <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ গোলাপ
                                            ফুল লাইট
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
                                        <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ গোলাপ
                                            ফুল লাইট
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
                                        <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ গোলাপ
                                            ফুল লাইট
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
                                        <h4 class="product__title font-normal md:mb-2 mb-1 text-center mt-6">৮০ পিছ গোলাপ
                                            ফুল লাইট
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
@endsection
