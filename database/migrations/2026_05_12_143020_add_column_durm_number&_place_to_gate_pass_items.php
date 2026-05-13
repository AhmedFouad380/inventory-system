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
        Schema::table('gate_pass_items', function (Blueprint $table) {
            //
            $table->string('durm_number')->after('qty_issued')->nullable();
            $table->text('place')->after('durm_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gate_pass_items', function (Blueprint $table) {
            //
        });
    }
};
