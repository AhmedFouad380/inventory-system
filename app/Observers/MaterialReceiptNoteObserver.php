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
        // If MRN is created already approved (e.g. import or CLI), process stock
        if ($mrn->status === 'approved') {
            $this->processApproved($mrn);
        }
    }

    public function updated(MaterialReceiptNote $mrn): void
    {
        // When status changes to approved, process stock
        if ($mrn->wasChanged('status')) {
            $original = $mrn->getOriginal('status');
            if ($original !== 'approved' && $mrn->status === 'approved') {
                $this->processApproved($mrn);
            }
        }
    }

    public function processApproved(MaterialReceiptNote $mrn): void
    {
        \Illuminate\Support\Facades\Log::info("ProcessApproved called for MRN: " . $mrn->id . " Items: " . $mrn->items->count());
        
        if ($mrn->status !== 'approved') {
            return;
        }

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
