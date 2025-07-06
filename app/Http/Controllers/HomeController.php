<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Offer;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active banners, ordered by 'order'
        $banners = Banner::where('status', true)
            ->orderBy('serial_no')
            ->get();

        // dd($banners);

        // Fetch offer products for multiple offer sections, eager load images and variants
        $offers = Offer::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with([
                'products.images',
                'products.variants',
            ])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Fetch categories with products, eager load primary image and variants
        $indexCategories = Category::whereHas('products', function ($query) {
            $query->where('visibility', 'public');
        })
            ->with([
                'products' => function ($query) {
                    $query->where('visibility', 'public')->take(4); // Limit to 4 products per category
                },
                'products.productVariants',
                'products.productImages' => function ($query) {
                    $query->where('is_primary', true);
                },
            ])
            ->take(2)
            ->get();

        // dd($categories);
        return view('pages.index', compact('banners', 'offers', 'indexCategories'));
    }
}
