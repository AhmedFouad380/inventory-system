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
        Schema::table('material_return_requests', function (Blueprint $table) {
            $table->foreignId('gate_pass_id')->nullable()->after('work_order_id')->constrained('gate_passes')->nullOnDelete();
            $table->foreignId('engineer_id')->nullable()->after('gate_pass_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('material_return_requests', function (Blueprint $table) {
            $table->dropForeign(['gate_pass_id']);
            $table->dropForeign(['engineer_id']);
            $table->dropColumn(['gate_pass_id', 'engineer_id']);
        });
    }
};
