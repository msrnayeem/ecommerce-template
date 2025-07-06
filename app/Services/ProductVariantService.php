<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\VariantValue;
use Illuminate\Support\Collection;

class ProductVariantService
{
    /**
     * Create variants for a product based on selected variant combinations
     *
     * @param  array  $variantCombinations  - Array of variant combinations
     * @param  array  $prices  - Array of prices for each combination
     */
    public function createVariants(Product $product, array $variantCombinations, array $prices = []): Collection
    {
        $createdVariants = collect();

        foreach ($variantCombinations as $index => $combination) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'variant_combination' => $combination,
                'price' => $prices[$index]['price'] ?? $product->price,
                'discount_price' => $prices[$index]['discount_price'] ?? $product->discount_price,
                'stock_quantity' => $prices[$index]['stock_quantity'] ?? 0,
                'is_active' => true,
            ]);

            $createdVariants->push($variant);
        }

        return $createdVariants;
    }

    /**
     * Generate all possible combinations from selected variants
     *
     * @param  array  $selectedVariants  - Array of variant_id => [value_ids]
     */
    public function generateCombinations(array $selectedVariants): array
    {
        if (empty($selectedVariants)) {
            return [];
        }

        $combinations = [[]];

        foreach ($selectedVariants as $variantId => $valueIds) {
            $newCombinations = [];

            foreach ($combinations as $combination) {
                foreach ($valueIds as $valueId) {
                    $newCombination = $combination;
                    $newCombination[$variantId] = $valueId;
                    $newCombinations[] = $newCombination;
                }
            }

            $combinations = $newCombinations;
        }

        return $combinations;
    }

    /**
     * Get variant display text for a combination
     */
    public function getVariantDisplayText(array $combination): string
    {
        $displayParts = [];

        foreach ($combination as $variantId => $valueId) {
            $variant = Variant::find($variantId);
            $value = VariantValue::find($valueId);

            if ($variant && $value) {
                $displayParts[] = $variant->name.': '.$value->name;
            }
        }

        return implode(', ', $displayParts);
    }

    /**
     * Find a product variant by combination
     */
    public function findVariantByCombination(Product $product, array $combination): ?ProductVariant
    {
        return $product->variants()
            ->where('variant_combination', json_encode($combination))
            ->first();
    }

    /**
     * Get available variant options for a product
     */
    public function getAvailableVariantOptions(Product $product): array
    {
        $options = [];
        $productVariants = $product->activeVariants()->get();

        foreach ($productVariants as $productVariant) {
            if ($productVariant->variant_combination) {
                foreach ($productVariant->variant_combination as $variantId => $valueId) {
                    if (! isset($options[$variantId])) {
                        $variant = Variant::find($variantId);
                        if ($variant) {
                            $options[$variantId] = [
                                'variant' => $variant,
                                'values' => collect(),
                            ];
                        }
                    }

                    $value = VariantValue::find($valueId);
                    if ($value && ! $options[$variantId]['values']->contains('id', $valueId)) {
                        $options[$variantId]['values']->push($value);
                    }
                }
            }
        }

        return $options;
    }

    /**
     * Update stock for a product variant
     *
     * @param  string  $operation  - 'add', 'subtract', 'set'
     */
    public function updateStock(ProductVariant $variant, int $quantity, string $operation = 'set'): bool
    {
        switch ($operation) {
            case 'add':
                $variant->stock_quantity += $quantity;
                break;
            case 'subtract':
                $variant->stock_quantity = max(0, $variant->stock_quantity - $quantity);
                break;
            case 'set':
            default:
                $variant->stock_quantity = max(0, $quantity);
                break;
        }

        return $variant->save();
    }

    /**
     * Reserve stock for a product variant
     */
    public function reserveStock(ProductVariant $variant, int $quantity): bool
    {
        if ($variant->available_stock >= $quantity) {
            $variant->reserved_quantity += $quantity;

            return $variant->save();
        }

        return false;
    }

    /**
     * Release reserved stock for a product variant
     */
    public function releaseStock(ProductVariant $variant, int $quantity): bool
    {
        $variant->reserved_quantity = max(0, $variant->reserved_quantity - $quantity);

        return $variant->save();
    }
}
