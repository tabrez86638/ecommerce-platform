<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $size = Attribute::updateOrCreate(
            ['slug' => 'size'],
            [
                'name' => 'Size',
                'type' => 'select',
                'is_active' => true,
            ]
        );

        foreach ([
            ['value' => 'Small', 'slug' => 'small', 'sort_order' => 1],
            ['value' => 'Medium', 'slug' => 'medium', 'sort_order' => 2],
            ['value' => 'Large', 'slug' => 'large', 'sort_order' => 3],
            ['value' => 'XL', 'slug' => 'xl', 'sort_order' => 4],
        ] as $item) {
            $size->values()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $color = Attribute::updateOrCreate(
            ['slug' => 'color'],
            [
                'name' => 'Color',
                'type' => 'select',
                'is_active' => true,
            ]
        );

        foreach ([
            ['value' => 'Black', 'slug' => 'black', 'sort_order' => 1],
            ['value' => 'White', 'slug' => 'white', 'sort_order' => 2],
            ['value' => 'Red', 'slug' => 'red', 'sort_order' => 3],
            ['value' => 'Blue', 'slug' => 'blue', 'sort_order' => 4],
        ] as $item) {
            $color->values()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}