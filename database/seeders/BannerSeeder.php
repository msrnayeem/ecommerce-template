<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'serial_no' => 1,
                'type' => 'header',
                'title' => 'ফ্ল্যাশ সেল - ৫০% ছাড়',
                'image' => 'https://images.unsplash.com/photo-1512295767273-ac109ac3acfa',
                'link' => '/offer/flash-sale',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'serial_no' => 2,
                'type' => 'header',
                'title' => 'ঈদের হাট - বিশেষ অফার',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
                'link' => '/offer/eid-bazaar',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('banners')->insert($banners);
    }
}
