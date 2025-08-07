<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Check for main_only query parameter
        $mainOnly = request()->has('main_only') && request()->get('main_only') == 1;

        // Eager load child categories and their products only if not main_only
        $category = Category::where('slug', $slug)
            ->when(! $mainOnly, function ($query) {
                return $query->with(['children.products' => function ($query) {
                    $query->where('visibility', 'public')
                        ->orderBy('is_featured', 'DESC') // Featured products first
                        ->orderBy('created_at', 'DESC')  // Then by newest
                        ->with([
                            'productVariants',
                            'productImages' => function ($query) {
                                $query->where('is_primary', true);
                            },
                        ]);
                }]);
            })
            ->firstOrFail();

        // Count total categories (main category + child categories) for normal view
        $totalCategories = $mainOnly ? 1 : 1 + $category->children->count();

        // Set pagination limit: 10 for main_only or single category, 4 for multiple categories
        $perPage = $mainOnly || $totalCategories == 1 ? 10 : 4;

        // Fetch paginated products for the main category
        $products = $category->products()
            ->where('visibility', 'public')
            ->orderBy('is_featured', 'DESC') // Featured products first
            ->orderBy('created_at', 'DESC')  // Then by newest
            ->with([
                'productVariants',
                'productImages' => function ($query) {
                    $query->where('is_primary', true);
                },
            ])
            ->paginate($perPage);

        // Show pagination links for main_only or single category
        $showPaginationLinks = $mainOnly || $totalCategories == 1;

        return view('pages.categories', [
            'indexCategory' => $category,
            'products' => $products,
            'showPaginationLinks' => $showPaginationLinks,
            'mainOnly' => $mainOnly,
        ]);
    }
}