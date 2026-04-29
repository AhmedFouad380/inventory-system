<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['name' => 'المستودع الرئيسي', 'code' => 'WH-MAIN', 'location' => 'المنطقة المركزية'],
            ['name' => 'مستودع الموقع - أ', 'code' => 'WH-SITE-A', 'location' => 'موقع العمل أ'],
            ['name' => 'مستودع الموقع - ب', 'code' => 'WH-SITE-B', 'location' => 'موقع العمل ب'],
            ['name' => 'مستودع الخردة', 'code' => 'WH-SCRAP', 'location' => 'منطقة التخزين الخارجية'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::updateOrCreate(['code' => $warehouse['code']], $warehouse);
        }
    }
}
