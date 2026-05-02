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
        if (Schema::hasColumn('work_orders', 'reservation_number')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn('reservation_number');
            });
        }

        if (Schema::hasColumn('material_receipt_notes', 'reservation_number')) {
            Schema::table('material_receipt_notes', function (Blueprint $table) {
                $table->dropColumn('reservation_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('reservation_number')->nullable();
        });
    }
};
