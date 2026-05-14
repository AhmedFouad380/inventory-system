<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->string('gp_number')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->dateTime('issued_at');
            $table->string('vehicle_number_id')->nullable();
            $table->string('recipient_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('destination_id')->nullable();
            $table->enum('status', ['draft', 'approved', 'issued', 'confirmed'])->default('draft');
            $table->foreignId('prepared_by')->constrained('users');
            $table->foreignId('warehouse_keeper_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('engineer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gate_passes');
    }
};
