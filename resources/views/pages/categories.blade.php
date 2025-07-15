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
            @if ($products->count())
                <div class="mt-10">
                    <div class="wh-sub-heading text-center">
                        <div class="flex flex-wrap justify-between items-center">
                            <h2 class="uppercase lg:text-5xl md:text-3xl text-xl font-bold text-black">
                                {{ $indexCategory->name }}
                            </h2>
                            <!-- Show "See All" button only if showPaginationLinks is false (multiple categories) -->
                            @if (!$showPaginationLinks)
                                <a href="{{ route('categories.show', $indexCategory->slug) }}?main_only=1"
                                    class="btn btn-sm btn-primary">See All</a>
                            @endif
                        </div>
                    </div>
                    <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <!-- Render pagination links only if showPaginationLinks is true -->
                    @if ($showPaginationLinks)
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Show child categories only if not main_only -->
            @if (!$mainOnly)
                @foreach ($indexCategory->children as $childCategory)
                    @if ($childCategory->products->count())
                        <div class="mt-16">
                            <div class="flex justify-between items-center mb-4 md:mb-712
                                <h4 class="uppercase
                                text-lg md:text-2xl md:tracking-widest font-bold">
                                {{ $childCategory->name }}
                                </h4>
                                <!-- Show "See All" button for child categories when multiple categories exist -->
                                <a href="{{ route('categories.show', $childCategory->slug) }}?main_only=1"
                                    class="btn btn-sm btn-primary">See All</a>
                            </div>

                            <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-5">
                                <!-- Limit to 4 products for child categories when multiple categories exist -->
                                @foreach ($childCategory->products->take(4) as $product)
                                    <x-product-card :product="$product" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </section>
@endsection
