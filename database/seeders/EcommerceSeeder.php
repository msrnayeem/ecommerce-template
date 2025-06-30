<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    public function run()
    {
        $now = now();

        $categories = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'depth' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Apparel and fashion',
                'depth' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Home decor and gardening',
                'depth' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('categories')->insert($categories);

        $productImages = [
            'Electronics' => [
                'https://picsum.photos/seed/electronics1/600',
                'https://picsum.photos/seed/electronics2/600',
                'https://picsum.photos/seed/electronics3/600',
            ],
            'Clothing' => [
                'https://picsum.photos/seed/clothing1/600',
                'https://picsum.photos/seed/clothing2/600',
                'https://picsum.photos/seed/clothing3/600',
            ],
            'Home & Garden' => [
                'https://picsum.photos/seed/home1/600',
                'https://picsum.photos/seed/home2/600',
                'https://picsum.photos/seed/home3/600',
            ],
        ];

        $products = [];
        $variants = [];
        $stocks = [];
        $images = [];
        $discounts = [];

        foreach ($categories as $cat) {
            for ($i = 1; $i <= 10; $i++) {
                $productId = (string) Str::uuid();
                $sku = strtoupper(substr($cat['slug'], 0, 4)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $name = $cat['name'] . ' Product ' . $i;
                $price = rand(100, 999);
                $discount = rand(0, 1) ? rand(10, 50) : null;

                $products[] = [
                    'id' => $productId,
                    'sku' => $sku,
                    'name' => $name,
                    'description' => 'Description for ' . $name,
                    'price' => $price,
                    'discount_price' => $discount ? $price - $discount : null,
                    'category_id' => $cat['id'],
                    'warranty' => '1 year',
                    'visibility' => 'public',
                    'is_featured' => rand(0, 1),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $variantId = (string) Str::uuid();
                $variants[] = [
                    'id' => $variantId,
                    'product_id' => $productId,
                    'variant_name' => 'Color',
                    'variant_value' => 'Black',
                    'price' => $price,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $stocks[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => rand(10, 100),
                    'status' => 'in_stock',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $imgList = $productImages[$cat['name']];
                shuffle($imgList);
                for ($imgIndex = 0; $imgIndex < 3; $imgIndex++) {
                    $images[] = [
                        'id' => (string) Str::uuid(),
                        'product_id' => $productId,
                        'image_path' => $imgList[$imgIndex % count($imgList)] . '?rand=' . uniqid(),
                        'alt_text' => $name . ' Image ' . ($imgIndex + 1),
                        'is_primary' => $imgIndex === 0,
                        'order' => $imgIndex + 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($discount) {
                    $discounts[] = [
                        'id' => (string) Str::uuid(),
                        'product_id' => $productId,
                        'discount_amount' => $discount,
                        'discount_type' => 'fixed',
                        'start_date' => $now,
                        'end_date' => $now->copy()->addDays(rand(10, 30)),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('products')->insert($products);
        DB::table('product_variants')->insert($variants);
        DB::table('stocks')->insert($stocks);
        DB::table('product_images')->insert($images);
        DB::table('discounts')->insert($discounts);
    }
}
