<?php

namespace App\Observers;

use App\Models\MaterialReturnRequest;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class MaterialReturnRequestObserver
{
    use HandlesStock;

    public function created(MaterialReturnRequest $mrr): void
    {
        // If created already approved, process stock
        if ($mrr->status === 'approved') {
            $this->processApproved($mrr);
        }
    }

    public function updated(MaterialReturnRequest $mrr): void
    {
        // When status changes to approved, process stock
        if ($mrr->wasChanged('status')) {
            $original = $mrr->getOriginal('status');
            if ($original !== 'approved' && $mrr->status === 'approved') {
                $this->processApproved($mrr);
            }
        }
    }

    public function processApproved(MaterialReturnRequest $mrr): void
    {
        \Illuminate\Support\Facades\Log::info("ProcessApproved called for MRR: " . $mrr->id . " Status: " . $mrr->status);
        // Ensure we only process if the status is approved
        if ($mrr->status !== 'approved') {
            return;
        }

        \Illuminate\Support\Facades\Log::info("MRR Items count: " . $mrr->items->count());
        foreach ($mrr->items as $item) {
            $this->updateStock(
                $mrr->work_order_id,
                $item->item_id,
                $mrr->warehouse_id,
                $item->qty_returned,
                StockLedger::TYPE_MRR,
                $mrr->id,
                $mrr->mrr_date,
                'qty_returned'
            );
        }
    }
}
