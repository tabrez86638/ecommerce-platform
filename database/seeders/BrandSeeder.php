<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Technology and consumer electronics brand.',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Consumer electronics and technology brand.',
            ],
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'Sportswear and footwear brand.',
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'Sportswear and lifestyle brand.',
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Consumer electronics and entertainment brand.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                [
                    'name' => $brand['name'],
                    'description' => $brand['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}