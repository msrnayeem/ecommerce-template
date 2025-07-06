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
                'https://picsum.photos/seed/electronics4/600',
                'https://picsum.photos/seed/electronics5/600',
            ],
            'Clothing' => [
                'https://picsum.photos/seed/clothing1/600',
                'https://picsum.photos/seed/clothing2/600',
                'https://picsum.photos/seed/clothing3/600',
                'https://picsum.photos/seed/clothing4/600',
                'https://picsum.photos/seed/clothing5/600',
            ],
            'Home & Garden' => [
                'https://picsum.photos/seed/home1/600',
                'https://picsum.photos/seed/home2/600',
                'https://picsum.photos/seed/home3/600',
                'https://picsum.photos/seed/home4/600',
                'https://picsum.photos/seed/home5/600',
            ],
        ];

        $variantColors = ['Black', 'White', 'Blue', 'Red', 'Green'];

        $products = [];
        $variants = [];
        $stocks = [];
        $images = [];

        foreach ($categories as $cat) {
            for ($i = 1; $i <= rand(5, 8); $i++) { // 5-8 products per category
                $productId = (string) Str::uuid();
                $sku = strtoupper(substr($cat['slug'], 0, 4)).'-'.str_pad($i, 3, '0', STR_PAD_LEFT);
                $name = $cat['name'].' Product '.$i;

                $price = rand(100, 999);
                $hasDiscount = rand(0, 1);
                $discount = $hasDiscount ? rand(10, 50) : null;

                // 70% products have variants
                $hasVariant = rand(1, 10) <= 7;

                $products[] = [
                    'id' => $productId,
                    'sku' => $sku,
                    'name' => $name,
                    'description' => 'Description for '.$name,
                    'price' => $hasVariant ? null : $price,
                    'discount_price' => ($hasVariant || ! $hasDiscount) ? null : $price - $discount,
                    'category_id' => $cat['id'],
                    'warranty' => '1 year',
                    'visibility' => 'public',
                    'is_featured' => rand(0, 1),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Product images (shared for all variants)
                $imgList = $productImages[$cat['name']];
                shuffle($imgList);
                $numProductImages = rand(3, 5);
                for ($imgIndex = 0; $imgIndex < $numProductImages; $imgIndex++) {
                    $images[] = [
                        'id' => (string) Str::uuid(),
                        'product_id' => $productId,
                        'variant_id' => null,
                        'image_path' => $imgList[$imgIndex % count($imgList)].'?rand='.uniqid(),
                        'alt_text' => $name.' Image '.($imgIndex + 1),
                        'is_primary' => $imgIndex === 0,
                        'order' => $imgIndex + 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($hasVariant) {
                    // 2-4 variants per product
                    $variantCount = rand(2, 4);
                    $usedColors = array_slice($variantColors, 0, $variantCount);
                    foreach ($usedColors as $vIndex => $color) {
                        $variantId = (string) Str::uuid();
                        $variantPrice = $price + ($vIndex * 10);
                        $variantDiscount = (rand(0, 1) && $hasDiscount) ? rand(5, 30) : null;
                        $variants[] = [
                            'id' => $variantId,
                            'product_id' => $productId,
                            'variant_name' => 'Color',
                            'variant_value' => $color,
                            'price' => $variantPrice,
                            'discount_price' => $variantDiscount ? $variantPrice - $variantDiscount : null,
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

                        // 1-2 variant-specific images
                        $numVariantImages = rand(1, 2);
                        for ($imgV = 0; $imgV < $numVariantImages; $imgV++) {
                            $imgSrc = $imgList[$imgV % count($imgList)];
                            $images[] = [
                                'id' => (string) Str::uuid(),
                                'product_id' => $productId,
                                'variant_id' => $variantId,
                                'image_path' => $imgSrc.'?variant='.strtolower($color).uniqid(),
                                'alt_text' => $name.' - '.$color.' Variant Image '.($imgV + 1),
                                'is_primary' => false,
                                'order' => $imgV + 100, // order to keep separate from main product images
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                } else {
                    // Only product-level stock
                    $stocks[] = [
                        'id' => (string) Str::uuid(),
                        'product_id' => $productId,
                        'variant_id' => null,
                        'quantity' => rand(10, 100),
                        'status' => 'in_stock',
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
    }
}
