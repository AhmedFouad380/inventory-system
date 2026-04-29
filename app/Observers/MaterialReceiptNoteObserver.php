<?php

namespace App\Observers;

use App\Models\MaterialReceiptNote;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class MaterialReceiptNoteObserver
{
    use HandlesStock;

    public function created(MaterialReceiptNote $mrn): void
    {
        if ($mrn->status === 'approved') {
            $this->processApproved($mrn);
        }
    }

    public function updated(MaterialReceiptNote $mrn): void
    {
        if ($mrn->isDirty('status') && $mrn->status === 'approved') {
            $this->processApproved($mrn);
        }
    }

    private function processApproved(MaterialReceiptNote $mrn): void
    {
        foreach ($mrn->items as $item) {
            $this->updateStock(
                $mrn->work_order_id,
                $item->item_id,
                $mrn->warehouse_id,
                $item->qty_received,
                StockLedger::TYPE_MRN,
                $mrn->id,
                $mrn->mrn_date,
                'qty_received'
            );
        }
    }
}
