@extends('layouts.app')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Categories', 'url' => '#'],
            ['label' => $category->name, 'url' => ''],
        ];
        $backUrl = route('home');
    @endphp

    <x-breadcrumb :breadcrumbs="$breadcrumbs" :backUrl="$backUrl" />

    <section class="py-4">
        <div class="container">
            <div>
                <!-- Category Sub Heading -->
                <div class="wh-sub-heading text-center">
                    <div class="flex flex-wrap justify-between items-center">
                        <h2 class="uppercase lg:text-5xl md:text-3xl text-xl font-bold text-black">
                            {{ $category->name }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="products-container grid xl:grid-cols-4 md:grid-cols-2 grid-cols-2 gap-2 md:gap-5">
                @forelse($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="text-gray-600 col-span-full text-center">No products found in this category.</p>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
