<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   
// ['productImages', 'productVariants']
// // Fetch the category by slug
        // $category = Category::where('slug', $slug)->firstOrFail();

        // // Fetch products in this category with pagination
        // $products = Product::where('category_id', $category->id)
        //     ->with(['productImages' => function ($query) {
        //         $query->where('is_primary', true);
        //     }])
        //     ->paginate(8); // Paginate 8 products per page
    /**
     * Display the specified resource.
     */
 public function show($slug)
{
    $indexCategory = Category::where('slug', $slug)
        ->with([
            'products' => function ($query) {
                $query->where('visibility', 'public')->take(4);
            },
            'products.productVariants',
            'products.productImages' => function ($query) {
                $query->where('is_primary', true);
            },
            'children.products' => function ($query) {
                $query->where('visibility', 'public')->take(4);
            },
            'children.products.productVariants',
            'children.products.productImages' => function ($query) {
                $query->where('is_primary', true);
            },
        ])
        ->first();

    return view('pages.categories', compact('indexCategory'));
}



}
