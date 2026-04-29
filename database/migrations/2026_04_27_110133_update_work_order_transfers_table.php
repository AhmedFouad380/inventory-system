<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_transfers', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['item_id']);
            $table->dropColumn(['item_id', 'qty_transferred']);
            
            if (!Schema::hasColumn('work_order_transfers', 'warehouse_id')) {
                $table->foreignId('warehouse_id')->nullable()->after('transfer_number')->constrained('warehouses');
            }
        });
    }

    public function down(): void
    {
        Schema::table('work_order_transfers', function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->decimal('qty_transferred', 12, 3)->default(0);
        });
    }
};
