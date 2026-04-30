<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add warehouse_id to transaction documents
        $tables = ['material_receipt_notes', 'gate_passes', 'material_disposal_requests', 'material_return_requests', 'stock_ledgers'];
        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'warehouse_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
                });
            }
        }

        // Update work_order_stocks
        Schema::table('work_order_stocks', function (Blueprint $table) {
            // Drop foreign keys first to allow index changes
            try {
                $table->dropForeign(['work_order_id']);
            } catch (\Exception $e) {}

            try {
                $table->dropForeign(['item_id']);
            } catch (\Exception $e) {}
            
            // Drop old unique index if it exists
            try {
                $table->dropUnique(['work_order_id', 'item_id']);
            } catch (\Exception $e) {}

            if (!Schema::hasColumn('work_order_stocks', 'warehouse_id')) {
                $table->foreignId('warehouse_id')->nullable()->after('item_id')->constrained('warehouses');
            }

            // Create new unique index
            $table->unique(['work_order_id', 'item_id', 'warehouse_id']);

            // Re-add foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down(): void
    {
        // Cleanup
    }
};
