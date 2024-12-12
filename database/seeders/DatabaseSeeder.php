<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  Category::create([
        //     'categoryName'=> 'Root',
        //     'categoryDescription'=> 'Root Category',
        //     'parentCategoryId' => null,
        //  ]);

         $this->call([
            // RoleSeeder::class,
            // PermissionSeeder::class,
            // CategorySeeder::class,
            // StaffSeeder::class,
            // UserSeeder::class,
            // UserRoleSeeder::class,
            // RolePermissionSeeder::class,
            // ProductSeeder::class,
            // UnitMeasurementSeeder::class,
            // ProductUnitPriceByMeasurementSeeder::class,
            // InventorySeeder::class,
            InventoryTransactionSeeder::class,
        ]);










    }
}
