<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->foreignId('vehicle_number_id')->nullable()->constrained('vehicle_numbers')->nullOnDelete();
            $table->foreignId('recipient_id')->nullable()->constrained('recipients')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gate_passes', function (Blueprint $table) {
            $table->dropForeign(['vehicle_number_id']);
            $table->dropForeign(['recipient_id']);
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['destination_id']);
            $table->dropColumn(['vehicle_number_id','recipient_id','driver_id','destination_id']);
        });
    }
};
