<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, footwear and fashion accessories.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Products for home and everyday living.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty and personal care products.',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}