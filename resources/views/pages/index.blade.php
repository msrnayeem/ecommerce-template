{{-- index --}}
@extends('layouts.app')

@section('content')
    <!-- Banner Section -->
    @php
        $imageUrl = env('IMAGE_LINK', 'http://localhost:8000');

    @endphp

    <div class="banner-section">
        <div class="container">
            <div id="banner-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($banners as $banner)
                            <li class="splide__slide">
                                <a href="{{ $banner->link ?? '#' }}">
                                    <img src="{{ $imageUrl . '/storage/' . $banner->image }}"
                                        alt="{{ $banner->title ?? 'Banner' }}" class="w-full object-cover"
                                        style="height: 400px;">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- Offer Sections -->
    @forelse ($offers as $offer)
        <div id="offer-{{ $offer->slug }}-section-wrapper">
            <div id="offer-{{ $offer->slug }}-products-list">
                <div class="container">
                    <div class="md:mt-16 mt-10">
                        <div class="flex justify-between items-center mb-4 md:mb-7">
                            <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">{{ $offer->name }}</h4>
                            <a href="{{ route('categories.show', $offer->slug) }}" class="btn btn-sm btn-primary">See
                                All</a>
                        </div>
                    </div>

                    <div id="splide-{{ $offer->slug }}" class="splide products-list">
                        <div class="splide__track">
                            <div class="splide__list">
                                @forelse ($offer->products as $product)
                                    <div class="splide__slide">
                                        <x-product-card :product="$product" />
                                    </div>
                                @empty
                                    <div class="splide__slide">
                                        <p class="text-center text-gray-500">No products available.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse


    <!-- Category Sections -->
    @foreach ($indexCategories as $indexCategory)
        <div id="products-list-by-category-{{ $indexCategory->id }}">
            <div class="container">
                <div class="md:mt-16 mt-10">
                    <div class="flex justify-between items-center mb-4 md:mb-7">
                        <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">{{ $indexCategory->name }}
                        </h4>
                        <a href="{{ route('categories.show', $indexCategory->slug) }}" class="btn btn-sm btn-primary">See
                            All</a>
                    </div>
                </div>

                <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                    @foreach ($indexCategory->products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Splide JS Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide('#banner-slider', {
                type: 'loop',
                autoplay: true,
                interval: 3000,
                pauseOnHover: true,
                arrows: true,
                pagination: true,
            }).mount();

            @foreach ($offers as $offer)
                new Splide('#splide-{{ $offer->slug }}', {
                    type: 'loop',
                    perPage: 4,
                    perMove: 1,
                    gap: '1rem',
                    breakpoints: {
                        1024: {
                            perPage: 3
                        },
                        768: {
                            perPage: 2
                        },
                        640: {
                            perPage: 1
                        }
                    },
                    arrows: true,
                    pagination: false,
                }).mount();
            @endforeach
        });
    </script>
@endsection
