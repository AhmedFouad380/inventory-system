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
        // Handled in Filament pages to ensure relationships are saved
    }

    public function updated(MaterialReceiptNote $mrn): void
    {
        // Handled in Filament pages to ensure relationships are saved
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
