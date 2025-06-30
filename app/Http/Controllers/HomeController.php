<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active banners, ordered by 'order'
        $banners = Banner::where('status', true)
            ->orderBy('serial_no')
            ->get();

        // Fetch offer products for multiple offer sections
        $offers = Offer::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->with(['products' => function ($query) {
                $query->where('visibility', 'public')
                      ->with(['images' => function ($q) {
                          $q->where('is_primary', true)->first();
                      }]);
            }])
            ->orderBy('created_at', 'desc')
            ->take(3) // Limit to 3 offer sections
            ->get();

        // Fetch categories with products
        $categories = Category::whereHas('products', function ($query) {
            $query->where('visibility', 'public');
        })
            ->with(['products' => function ($query) {
                $query->where('visibility', 'public')
                      ->with(['images' => function ($q) {
                          $q->where('is_primary', true)->first();
                      }])
                      ->take(5); // Limit to 5 products per category
            }])
            ->take(2) // Limit to 2 categories
            ->get();

        return view('pages.index', compact('banners', 'offers', 'categories'));
    }
}