<?php

namespace App\Traits;

use App\Models\WorkOrderStock;
use App\Models\StockLedger;
use Illuminate\Support\Facades\DB;

trait HandlesStock
{
    protected function updateStock(
        int $workOrderId,
        int $itemId,
        int $warehouseId,
        float $qty,
        string $transactionType,
        int $transactionId,
        string $date,
        string $stockField // qty_received, qty_issued, etc.
    ): void {
        \Illuminate\Support\Facades\Log::critical("Updating stock: WO: $workOrderId, Item: $itemId, Qty: $qty, Type: $transactionType");
        DB::transaction(function () use ($workOrderId, $itemId, $warehouseId, $qty, $transactionType, $transactionId, $date, $stockField) {
            // 1. Find or create WorkOrderStock record
            $stock = WorkOrderStock::firstOrCreate(
                [
                    'work_order_id' => $workOrderId,
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouseId,
                ],
                [
                    'qty_received' => 0, 'qty_issued' => 0, 'qty_disposed' => 0,
                    'qty_returned' => 0, 'qty_transfer_out' => 0, 'qty_transfer_in' => 0,
                    'balance' => 0,
                ]
            );

            // 2. Update the specific field
            $stock->increment($stockField, $qty);

            // 3. Create StockLedger entry
            $qtyIn = in_array($transactionType, [StockLedger::TYPE_MRN, StockLedger::TYPE_TRANSFER_IN, StockLedger::TYPE_MRR]) ? $qty : 0;
            $qtyOut = $qtyIn === 0 ? $qty : 0;

            StockLedger::create([
                'work_order_id' => $workOrderId,
                'item_id' => $itemId,
                'warehouse_id' => $warehouseId,
                'transaction_type' => $transactionType,
                'transaction_id' => $transactionId,
                'transaction_date' => $date,
                'qty_in' => $qtyIn,
                'qty_out' => $qtyOut,
                'balance_after' => 0, // Will be updated
                // when running in CLI or queue there may be no authenticated user
                // fallback to system user id 1 to satisfy NOT NULL constraint
                'created_by' => auth()->id() ?? 1,
            ]);

            // 4. Recalculate Balance
            $stock->fresh()->recalculateBalance();
            
            // Update balance_after in ledger
            StockLedger::where('transaction_type', $transactionType)
                ->where('transaction_id', $transactionId)
                ->where('item_id', $itemId)
                ->update(['balance_after' => $stock->fresh()->balance]);
        });
    }
}
