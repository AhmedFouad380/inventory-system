<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->foreignId('item_id')->constrained('items');
            $table->enum('transaction_type', ['mrn', 'gate_pass', 'mdr', 'mrr', 'transfer_in', 'transfer_out']);
            $table->unsignedBigInteger('transaction_id');
            $table->date('transaction_date');
            $table->decimal('qty_in', 12, 3)->default(0);
            $table->decimal('qty_out', 12, 3)->default(0);
            $table->decimal('balance_after', 12, 3);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['work_order_id', 'item_id']);
            $table->index('transaction_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
