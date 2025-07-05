<?php

namespace Database\Seeders;

use App\Models\Variant;
use App\Models\VariantValue;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        // Color Variant
        $colorVariant = Variant::create([
            'name' => 'Color',
            'slug' => 'color',
            'description' => 'Product color variations',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $colors = [
            ['name' => 'Red', 'color_code' => '#FF0000'],
            ['name' => 'Blue', 'color_code' => '#0000FF'],
            ['name' => 'Green', 'color_code' => '#00FF00'],
            ['name' => 'Black', 'color_code' => '#000000'],
            ['name' => 'White', 'color_code' => '#FFFFFF'],
            ['name' => 'Yellow', 'color_code' => '#FFFF00'],
            ['name' => 'Purple', 'color_code' => '#800080'],
            ['name' => 'Orange', 'color_code' => '#FFA500'],
        ];

        foreach ($colors as $index => $color) {
            VariantValue::create([
                'variant_id' => $colorVariant->id,
                'name' => $color['name'],
                'slug' => strtolower($color['name']),
                'color_code' => $color['color_code'],
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Size Variant
        $sizeVariant = Variant::create([
            'name' => 'Size',
            'slug' => 'size',
            'description' => 'Product size variations',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        foreach ($sizes as $index => $size) {
            VariantValue::create([
                'variant_id' => $sizeVariant->id,
                'name' => $size,
                'slug' => strtolower($size),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Storage Variant (for electronics)
        $storageVariant = Variant::create([
            'name' => 'Storage',
            'slug' => 'storage',
            'description' => 'Storage capacity variations',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $storages = ['64GB', '128GB', '256GB', '512GB', '1TB', '2TB'];

        foreach ($storages as $index => $storage) {
            VariantValue::create([
                'variant_id' => $storageVariant->id,
                'name' => $storage,
                'slug' => strtolower(str_replace('GB', 'gb', $storage)),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Material Variant
        $materialVariant = Variant::create([
            'name' => 'Material',
            'slug' => 'material',
            'description' => 'Product material variations',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $materials = ['Cotton', 'Polyester', 'Wool', 'Silk', 'Denim', 'Leather', 'Plastic', 'Metal'];

        foreach ($materials as $index => $material) {
            VariantValue::create([
                'variant_id' => $materialVariant->id,
                'name' => $material,
                'slug' => strtolower($material),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
