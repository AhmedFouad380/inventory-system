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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);
            $table->renameColumn('contractor_id', 'supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->renameColumn('supplier_id', 'contractor_id');
            $table->foreign('contractor_id')->references('id')->on('contractors')->nullOnDelete();
        });
    }
};
