<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleNumbersSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleNumbers = [
            '2042',
            '2606',
            '3176',
            '3889',
            '3892',
            '3902',
            '3901',
            '3900',
            '3032',
            '3956',
            '3957',
            '3961',
            '3960',
            '3962',
            '3969',
            '3970',
            '3977',
            '3978',
            '3030',
            '3031',
            '3606',
            '3703',
            '3396',
            '1781',
            '2515',
            '2236',
            '3518',
            '2172',
            '1383',
            '3025',
            '3979',
        ];

        foreach ($vehicleNumbers as $vehicleNumber) {
            DB::table('vehicle_numbers')->updateOrInsert(
                ['value' => $vehicleNumber],
                [
                    'value' => $vehicleNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}