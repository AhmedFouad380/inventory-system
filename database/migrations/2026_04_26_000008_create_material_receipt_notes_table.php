<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_receipt_notes', function (Blueprint $table) {
            $table->id();
            $table->string('mrn_number')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->date('mrn_date');
            $table->string('delivery_note_ref')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('contract_ref')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'approved'])->default('draft');
            $table->foreignId('prepared_by')->constrained('users');
            $table->foreignId('warehouse_keeper_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_receipt_notes');
    }
};
