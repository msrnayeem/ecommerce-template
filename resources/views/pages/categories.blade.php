@extends('layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Categories', 'url' => '#'],
            ['label' => $indexCategory->name, 'url' => ''],
        ];
        $backUrl = route('home');
    @endphp

    <x-breadcrumb :breadcrumbs="$breadcrumbs" :backUrl="$backUrl" />

    <section class="py-4">
        <div class="container">
            @if ($indexCategory->products->count())
                <div class="mt-10">
                    <div class="wh-sub-heading text-center">
                        <div class="flex flex-wrap justify-between items-center">
                            <h2 class="uppercase lg:text-5xl md:text-3xl text-xl font-bold text-black">
                                {{ $indexCategory->name }}
                            </h2>
                        </div>
                    </div>
                    <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                        @foreach ($indexCategory->products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif

            @foreach ($indexCategory->children as $childCategory)
                @if ($childCategory->products->count())
                    <div class="mt-16">
                        <div class="flex justify-between items-center mb-4 md:mb-7">
                            <h4 class="uppercase text-lg md:text-2xl md:tracking-widest font-bold">
                                {{ $childCategory->name }}
                            </h4>
                            <a href="{{ route('categories.show', $childCategory->slug) }}"
                                class="btn btn-sm btn-primary">See All</a>
                        </div>

                        <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                            @foreach ($childCategory->products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
