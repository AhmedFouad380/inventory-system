<?php

namespace App\Observers;

use App\Models\WorkOrderTransfer;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class WorkOrderTransferObserver
{
    use HandlesStock;

    public function created(WorkOrderTransfer $transfer): void
    {
        // Removed to prevent race conditions with Filament relationship saving
    }

    public function updated(WorkOrderTransfer $transfer): void
    {
        // Removed to prevent race conditions with Filament relationship saving
    }

    public function processApproved(WorkOrderTransfer $transfer): void
    {
        // Ensure we only process if the status is approved
        if ($transfer->status !== 'approved') {
            return;
        }

        foreach ($transfer->items as $item) {
            // 1. Deduct from Source Work Order
            $this->updateStock(
                $transfer->from_work_order_id,
                $item->item_id,
                $transfer->warehouse_id,
                $item->qty_transferred,
                StockLedger::TYPE_TRANSFER_OUT,
                $transfer->id,
                $transfer->transfer_date,
                'qty_transfer_out'
            );

            // 2. Add to Destination Work Order
            $this->updateStock(
                $transfer->to_work_order_id,
                $item->item_id,
                $transfer->warehouse_id,
                $item->qty_transferred,
                StockLedger::TYPE_TRANSFER_IN,
                $transfer->id,
                $transfer->transfer_date,
                'qty_transfer_in'
            );
        }
    }
}
