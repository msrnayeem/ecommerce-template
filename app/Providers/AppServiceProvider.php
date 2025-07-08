<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Category;
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
        View::composer('*', function ($view) {
            $logo = Banner::where('type', 'logo')->where('status', true)->value('image');

            $categories = Category::whereNull('parent_id')->get();
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            $cartItemCount = array_sum(array_column($cart, 'quantity'));

            $view->with([
                'logo' => $logo,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,
            ]);
        });

    }
}
