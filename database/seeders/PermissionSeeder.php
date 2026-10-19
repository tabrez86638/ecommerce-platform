<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],
            ['name' => 'Manage Products', 'slug' => 'manage-products'],
            ['name' => 'Manage Categories', 'slug' => 'manage-categories'],
            ['name' => 'Manage Brands', 'slug' => 'manage-brands'],
            ['name' => 'Manage Attributes', 'slug' => 'manage-attributes'],
            ['name' => 'Manage Orders', 'slug' => 'manage-orders'],
            ['name' => 'Manage Customers', 'slug' => 'manage-customers'],
            ['name' => 'Manage Coupons', 'slug' => 'manage-coupons'],
            ['name' => 'Manage Reviews', 'slug' => 'manage-reviews'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings'],
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'View Reports', 'slug' => 'view-reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }
    }
}