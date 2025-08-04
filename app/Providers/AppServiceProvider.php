<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Setting;
use App\Models\StoreInformation;
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
            $logo = Setting::getValue('logo');

            $categories = Category::whereNull('parent_id')->get();
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            $cartItemCount = array_sum(array_column($cart, 'quantity'));

            $facebook = Setting::getValue('customer_facebook');
            $youtube = Setting::getValue('customer_youtube');
            $tiktok = Setting::getValue('customer_tiktok');
            $instagram = Setting::getValue('customer_instagram');
            $whatsappRaw = Setting::getValue('customer_whatsapp') ?? '01680847204';
            $whatsapp = $whatsappRaw ? preg_replace('/\D/', '', $whatsappRaw) : null;

            $store = StoreInformation::first();
            if ($store) {
                $company_name = $store->name;
                $support_email = $store->email;
                $address = $store->address;
                $website = $store->website ?? request()->getHost();
                $phone_number = $store->phone_number ?? '01680847204';
            }

            $view->with([
                'logo' => $logo,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,

                // Social values
                'facebook' => $facebook,
                'youtube' => $youtube,
                'tiktok' => $tiktok,
                'instagram' => $instagram,
                'whatsapp' => $whatsapp,

                // Store information
                'company_name' => $company_name ?? null,
                'support_email' => $support_email ?? null,
                'address' => $address ?? null,
                'website' => $website ?? null,
                'phone_number' => $phone_number ?? '01680847204',
            ]);
        });
    }
}
