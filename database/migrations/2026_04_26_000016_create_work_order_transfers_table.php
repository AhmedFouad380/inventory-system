<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->foreignId('from_work_order_id')->constrained('work_orders');
            $table->foreignId('to_work_order_id')->constrained('work_orders');
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty_transferred', 12, 3);
            $table->date('transfer_date');
            $table->enum('status', ['draft', 'approved'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_transfers');
    }
};
