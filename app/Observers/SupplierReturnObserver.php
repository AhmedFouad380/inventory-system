<?php

namespace App\Observers;

use App\Models\SupplierReturn;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class SupplierReturnObserver
{
    use HandlesStock;

    public function created(SupplierReturn $record): void
    {
        if ($record->status === 'approved') {
            $this->processApproved($record);
        }
    }

    public function updated(SupplierReturn $record): void
    {
        if ($record->wasChanged('status')) {
            $original = $record->getOriginal('status');
            if ($original !== 'approved' && $record->status === 'approved') {
                $this->processApproved($record);
            }
        }
    }

    public function processApproved(SupplierReturn $record): void
    {
        if ($record->status !== 'approved') {
            return;
        }

        foreach ($record->items as $item) {
            $this->updateStock(
                $record->work_order_id,
                $item->item_id,
                $record->warehouse_id,
                $item->qty,
                StockLedger::TYPE_SUPPLIER_RETURN,
                $record->id,
                $record->return_date,
                'qty_returned_to_supplier'
            );
        }
    }
}
