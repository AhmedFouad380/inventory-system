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

 
        // // 1. Create Admin User
        // $admin = User::updateOrCreate(
        //     ['email' => 'admin@admin.com'],
        //     [
        //         'name' => 'Admin User',
        //         'password' => bcrypt('123456'),
        //     ]
        // );

        // // 2. Create Category ID 1 if not exists
        // $category = Category::firstOrCreate(
        //     ['id' => 1],
        //     [
        //         'name' => 'General Materials',
        //         'created_by' => $admin->id,
        //     ]
        // );

        // // 3. Add items from the image
        // $items = [
        //     ['code' => '908020201', 'name' => 'LOCK PAD'],
        //     ['code' => '908312027', 'name' => 'PILLAR,STL,LV,400A,5WAY,W/O BASE,BEIGE'],
        //     ['code' => '908121008', 'name' => 'TERM 4X70'],
        //     ['code' => '908121010', 'name' => 'TERM KIT,STR,1KV,4X300MM2,AL'],
        //     ['code' => '908202030', 'name' => 'LUG 35 CU'],
        //     ['code' => '908202054', 'name' => 'ROD,GROUND,16 MM DIA X 2400 MM LG,COPPER'],
        //     ['code' => '908202098', 'name' => 'G CLAMP'],
        //     ['code' => '908122011', 'name' => 'BT LUG 300'],
        //     ['code' => '908111101', 'name' => 'GROUND WIRE 35 CU'],
        //     ['code' => '908111005', 'name' => 'CABLE,PWR,600V/1KV,AL,4C,70MM2,XLPE'],
        //     ['code' => '908111007', 'name' => 'CABLE,PWR,600V/1KV,AL,4C,300MM2,XLPE'],
        // ];

        // foreach ($items as $itemData) {
        //     Item::updateOrCreate(
        //         ['item_code' => $itemData['code']],
        //         [
        //             'name' => $itemData['name'],
        //             'description' => $itemData['name'], // Use name as description for now
        //             'category_id' => $category->id,
        //             'created_by' => $admin->id,
        //             'unit' => 'pcs', // Enums are lowercase
        //             'is_active' => true,
        //         ]
        //     );
        // }
$this->call([
            InventoryNamesSeeder::class,
            VehicleNumbersSeeder::class
        ]);
        // // 3. Create Projects
        // Project::factory(5)->create(['created_by' => $admin->id]);
        
        // ... rest of the file ...
    }
}
