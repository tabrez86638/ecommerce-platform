<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics')->firstOrFail();
        $fashion = Category::where('slug', 'fashion')->firstOrFail();

        $apple = Brand::where('slug', 'apple')->firstOrFail();
        $nike = Brand::where('slug', 'nike')->firstOrFail();

        $size = Attribute::where('slug', 'size')->firstOrFail();
        $color = Attribute::where('slug', 'color')->firstOrFail();

        $medium = $size->values()->where('slug', 'medium')->firstOrFail();
        $large = $size->values()->where('slug', 'large')->firstOrFail();

        $black = $color->values()->where('slug', 'black')->firstOrFail();
        $white = $color->values()->where('slug', 'white')->firstOrFail();

        // Product 1
        $iphone = Product::updateOrCreate(
            ['slug' => 'iphone-17-pro'],
            [
                'category_id' => $electronics->id,
                'brand_id' => $apple->id,
                'name' => 'iPhone 17 Pro',
                'sku' => 'IPHONE-17-PRO',
                'short_description' => 'Premium smartphone for everyday use.',
                'description' => 'A sample premium smartphone product for testing the ecommerce platform.',
                'price' => 1299.00,
                'sale_price' => 1199.00,
                'cost_price' => 900.00,
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'iPhone 17 Pro',
                'meta_description' => 'Buy the iPhone 17 Pro from our online store.',
            ]
        );

        // Product 2
        $shoes = Product::updateOrCreate(
            ['slug' => 'nike-running-shoes'],
            [
                'category_id' => $fashion->id,
                'brand_id' => $nike->id,
                'name' => 'Nike Running Shoes',
                'sku' => 'NIKE-RUN-001',
                'short_description' => 'Comfortable running shoes for daily workouts.',
                'description' => 'A sample fashion product with size and color variants.',
                'price' => 149.00,
                'sale_price' => 119.00,
                'cost_price' => 80.00,
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Nike Running Shoes',
                'meta_description' => 'Comfortable Nike running shoes.',
            ]
        );

        // Variants for iPhone
        $iphoneVariant = $iphone->variants()->updateOrCreate(
            ['sku' => 'IPHONE-17-PRO-BLACK'],
            [
                'price' => 1199.00,
                'sale_price' => 1149.00,
                'weight' => 0.25,
                'is_active' => true,
            ]
        );

        $iphoneVariant->attributeValues()->sync([
            $black->id,
        ]);

        // Variant 1 - Nike Medium Black
        $variant = $shoes->variants()->updateOrCreate(
            ['sku' => 'NIKE-RUN-M-BLACK'],
            [
                'price' => 119.00,
                'sale_price' => 99.00,
                'weight' => 0.80,
                'is_active' => true,
            ]
        );

        $variant->attributeValues()->sync([
            $medium->id,
            $black->id,
        ]);

        // Variant 2 - Nike Large White
        $variant = $shoes->variants()->updateOrCreate(
            ['sku' => 'NIKE-RUN-L-WHITE'],
            [
                'price' => 129.00,
                'sale_price' => 109.00,
                'weight' => 0.85,
                'is_active' => true,
            ]
        );

        $variant->attributeValues()->sync([
            $large->id,
            $white->id,
        ]);
    }
}