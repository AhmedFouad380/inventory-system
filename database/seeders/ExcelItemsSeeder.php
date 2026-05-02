<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExcelItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = base_path('items_data.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("File not found: {$jsonPath}");
            return;
        }

        $itemsData = json_decode(File::get($jsonPath), true);
        $admin = User::where('email', 'admin@admin.com')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        $this->command->info('Seeding ' . count($itemsData) . ' items...');

        foreach ($itemsData as $data) {
            // 1. Get or Create Category
            $category = Category::firstOrCreate(
                ['name' => $data['category']],
                ['created_by' => $admin->id]
            );

            // 2. Create or Update Item
            Item::updateOrCreate(
                ['item_code' => $data['code']],
                [
                    'name' => $data['name'],
                    'description' => $data['name'],
                    'unit' => $data['unit'] ?: 'pcs',
                    'category_id' => $category->id,
                    'created_by' => $admin->id,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Seeding completed!');
    }
}
