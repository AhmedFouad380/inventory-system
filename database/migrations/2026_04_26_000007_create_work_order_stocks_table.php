<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty_received', 12, 3)->default(0);
            $table->decimal('qty_issued', 12, 3)->default(0);
            $table->decimal('qty_disposed', 12, 3)->default(0);
            $table->decimal('qty_returned', 12, 3)->default(0);
            $table->decimal('qty_transfer_out', 12, 3)->default(0);
            $table->decimal('qty_transfer_in', 12, 3)->default(0);
            $table->decimal('balance', 12, 3)->default(0);
            $table->timestamps();

            $table->unique(['work_order_id', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_stocks');
    }
};
