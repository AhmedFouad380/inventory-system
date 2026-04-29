<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contractor;
use App\Models\Item;
use App\Models\Project;
use App\Models\Site;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('123456'),
            ]
        );

        // 2. Create Categories
        Category::factory(8)->create(['created_by' => $admin->id]);

        // 3. Create Projects
        Project::factory(5)->create(['created_by' => $admin->id]);

        // 4. Create Sites
        Site::factory(10)->create(['created_by' => $admin->id]);

        // 5. Create Contractors
        Contractor::factory(6)->create(['created_by' => $admin->id]);

        // 6. Create Suppliers
        Supplier::factory(10)->create();

        // 7. Create Items
        Item::factory(20)->create(['created_by' => $admin->id]);

        // 8. Create Work Orders
        WorkOrder::factory(15)->create(['created_by' => $admin->id]);
    }
}
