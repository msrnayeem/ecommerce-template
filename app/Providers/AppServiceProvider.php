<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Banner;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // logo
        View::share('logo', Banner::where('type', 'logo')->where('status', true)->value('image'));

        // Share categories with all views
        View::share('categories', Category::whereNull('parent_id')->get());

        View::share('cartItemCount', function () {
            $cart = json_decode(Cookie::get('cart', '[]'), true);

            return array_sum(array_column($cart, 'quantity'));
        });
    }
}
