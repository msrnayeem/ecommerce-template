<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all views
        View::share('categories', Category::whereNull('parent_id')->get());

        View::share('cartItemCount', function () {
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            return array_sum(array_column($cart, 'quantity'));
        });
    }
}
