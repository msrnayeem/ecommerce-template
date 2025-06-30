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

        // Fetch offer products for multiple offer sections, eager load images and variants
        $offers = Offer::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->with([
                'products.images',        // eager load all images
                'products.variants',      // eager load variants if you want to show variant price
            ])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Fetch categories with products, eager load images and variants
        $categories = Category::whereHas('products', function ($query) {
            $query->where('visibility', 'public');
        })
            ->with([
                'products.images',
                'products.variants',
            ])
            ->take(2)
            ->get();

        return view('pages.index', compact('banners', 'offers', 'categories'));
    }
}