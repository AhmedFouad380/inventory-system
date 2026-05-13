<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryNamesSeeder extends Seeder
{
    public function run(): void
    {
        $recipients = [
            ['name' => 'SURIYA KUMAR RIJAL', 'emp_number' => '2803'],
            ['name' => 'MAKHBOR HOSSAIN', 'emp_number' => '3950'],
            ['name' => 'MOHAMMAD HOSSAIN', 'emp_number' => '4013'],
            ['name' => 'SAHAB-UDDIN LAL', 'emp_number' => '4038'],
            ['name' => 'SAIFUL KHAN', 'emp_number' => '4021'],
            ['name' => 'MIZAN MOHAMMAD', 'emp_number' => '4022'],
            ['name' => 'MOSHARAF HOSSAIN', 'emp_number' => '4081'],
            ['name' => 'MOHAMMAD JULAS', 'emp_number' => '4092'],
            ['name' => 'MOHAMMED SABUJ', 'emp_number' => '4127'],
            ['name' => 'JIBAN DEWAN', 'emp_number' => '4130'],
            ['name' => 'KHALID MEHMOOD', 'emp_number' => '4591'],
            ['name' => 'ABDUL SHAHID', 'emp_number' => '4618'],
            ['name' => 'RAMESH KUMAR', 'emp_number' => '4735'],
            ['name' => 'BHUTAI MIYA', 'emp_number' => '5287'],
            ['name' => 'ARIF MUAD', 'emp_number' => '7901'],
            ['name' => 'EDWIN', 'emp_number' => '8211'],
            ['name' => 'VIJAY KUMAR', 'emp_number' => '8524'],
            ['name' => 'IMRAN ARSHAD', 'emp_number' => '10235'],
            ['name' => 'BANKE LAL', 'emp_number' => '10316'],
            ['name' => 'TASSAWAR HUSSAIN', 'emp_number' => '10654'],
            ['name' => 'WASEEM AKTHER', 'emp_number' => '20999'],
        ];

        $drivers = [
            ['name' => 'SURIYA KUMAR RIJAL', 'emp_number' => '2803'],
            ['name' => 'MAKHBOR HOSSAIN', 'emp_number' => '3950'],
            ['name' => 'MOHAMMAD HOSSAIN', 'emp_number' => '4013'],
            ['name' => 'CHAND BABU', 'emp_number' => '3864'],
            ['name' => 'SAIFUL KHAN', 'emp_number' => '4021'],
            ['name' => 'NIAZ AHMED', 'emp_number' => '9745'],
            ['name' => 'MOSHARAF HOSSAIN', 'emp_number' => '4081'],
            ['name' => 'MOHAMMAD JULAS', 'emp_number' => '4092'],
            ['name' => 'MOHAMMED SABUJ', 'emp_number' => '4127'],
            ['name' => 'JIBAN DEWAN', 'emp_number' => '4130'],
            ['name' => 'KHALID MEHMOOD', 'emp_number' => '4591'],
            ['name' => 'ABDUL SHAHID', 'emp_number' => '4618'],
            ['name' => 'TASSAWAR HUSSAIN', 'emp_number' => '10654'],
            ['name' => 'BHUTAI MIYA', 'emp_number' => '5287'],
            ['name' => 'ARIF MUAD', 'emp_number' => '7901'],
            ['name' => 'SHESH KANTA', 'emp_number' => '6186'],
            ['name' => 'JUNAID AHMED', 'emp_number' => '9674'],
            ['name' => 'IMRAN ARSHAD', 'emp_number' => '10235'],
            ['name' => 'BANKE LAL', 'emp_number' => '10316'],
            ['name' => 'SHAIK GHOUSE', 'emp_number' => '2464'],
            ['name' => 'SATPAL CHARAN', 'emp_number' => '3790'],
        ];

        $warehouseKeepers = [
            ['name' => 'RAJA M ASIM KHAN', 'emp_number' => '19569'],
            ['name' => 'Khawar Ali', 'emp_number' => '13987'],
        ];

        $siteEngineers = [
            ['name' => 'RAMAH AHMED', 'emp_number' => '20358'],
            ['name' => 'AHMED IDRIS', 'emp_number' => '20624'],
        ];

        $destinations = [
            ['value' => 'Jubail City'],
            ['value' => 'JIC'],
            ['value' => 'Al Hada'],
            ['value' => 'Tofiyah'],
            ['value' => 'AL Dahiyah'],
            ['value' => 'Qateef'],
        ];

        foreach ($recipients as $recipient) {
            DB::table('recipients')->updateOrInsert(
                ['emp_number' => $recipient['emp_number']],
                [
                    'name' => $recipient['name'],
                    'emp_number' => $recipient['emp_number'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        foreach ($drivers as $driver) {
            DB::table('drivers')->updateOrInsert(
                ['emp_number' => $driver['emp_number']],
                [
                    'name' => $driver['name'],
                    'emp_number' => $driver['emp_number'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        if (DB::getSchemaBuilder()->hasTable('warehouse_keepers')) {
            foreach ($warehouseKeepers as $warehouseKeeper) {
                DB::table('warehouse_keepers')->updateOrInsert(
                    ['emp_number' => $warehouseKeeper['emp_number']],
                    [
                        'name' => $warehouseKeeper['name'],
                        'emp_number' => $warehouseKeeper['emp_number'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        if (DB::getSchemaBuilder()->hasTable('site_engineers')) {
            foreach ($siteEngineers as $siteEngineer) {
                DB::table('site_engineers')->updateOrInsert(
                    ['emp_number' => $siteEngineer['emp_number']],
                    [
                        'name' => $siteEngineer['name'],
                        'emp_number' => $siteEngineer['emp_number'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        foreach ($destinations as $destination) {
            DB::table('destinations')->updateOrInsert(
                ['value' => $destination['value']],
                [
                    'value' => $destination['value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}