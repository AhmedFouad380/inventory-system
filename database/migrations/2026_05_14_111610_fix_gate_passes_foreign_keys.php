<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Migrate missing warehouse keepers from users table to preserve data
        $missingKeeperIds = DB::table('gate_passes')
            ->whereNotNull('warehouse_keeper_id')
            ->whereNotIn('warehouse_keeper_id', function ($query) {
                $query->select('id')->from('warehouse_keepers');
            })
            ->distinct()
            ->pluck('warehouse_keeper_id');

        if ($missingKeeperIds->isNotEmpty()) {
            $usersToMigrate = DB::table('users')->whereIn('id', $missingKeeperIds)->get(['id', 'name']);
            $insertData = $usersToMigrate->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();
            
            if (!empty($insertData)) {
                DB::table('warehouse_keepers')->insert($insertData);
            }
        }

        // 2. Migrate missing site engineers from users table to preserve data
        $missingEngineerIds = DB::table('gate_passes')
            ->whereNotNull('engineer_id')
            ->whereNotIn('engineer_id', function ($query) {
                $query->select('id')->from('site_engineers');
            })
            ->distinct()
            ->pluck('engineer_id');

        if ($missingEngineerIds->isNotEmpty()) {
            $usersToMigrate = DB::table('users')->whereIn('id', $missingEngineerIds)->get(['id', 'name']);
            $insertData = $usersToMigrate->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();
            
            if (!empty($insertData)) {
                DB::table('site_engineers')->insert($insertData);
            }
        }

        // 3. Nullify any remaining invalid IDs to prevent foreign key constraint errors
        DB::table('gate_passes')
            ->whereNotNull('warehouse_keeper_id')
            ->whereNotIn('warehouse_keeper_id', function ($query) {
                $query->select('id')->from('warehouse_keepers');
            })
            ->update(['warehouse_keeper_id' => null]);

        DB::table('gate_passes')
            ->whereNotNull('engineer_id')
            ->whereNotIn('engineer_id', function ($query) {
                $query->select('id')->from('site_engineers');
            })
            ->update(['engineer_id' => null]);

        // 4. Finally apply the new foreign keys
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->dropForeign(['warehouse_keeper_id']);
            $table->dropForeign(['engineer_id']);

            $table->foreign('warehouse_keeper_id')->references('id')->on('warehouse_keepers')->nullOnDelete();
            $table->foreign('engineer_id')->references('id')->on('site_engineers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->dropForeign(['warehouse_keeper_id']);
            $table->dropForeign(['engineer_id']);

            $table->foreign('warehouse_keeper_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('engineer_id')->references('id')->on('users')->nullOnDelete();
        });
    }
};
