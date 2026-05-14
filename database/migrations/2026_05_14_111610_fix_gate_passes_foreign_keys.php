<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
