<?php

namespace App\Observers;

use App\Models\GatePass;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class GatePassObserver
{
    use HandlesStock;

    public function created(GatePass $gp): void
    {
        // If GatePass created already approved, process stock
        if ($gp->status === 'approved') {
            $this->processApproved($gp);
        }
    }

    public function updated(GatePass $gp): void
    {
        // When status changes to approved, process stock
        if ($gp->wasChanged('status')) {
            $original = $gp->getOriginal('status');
            if ($original !== 'approved' && $gp->status === 'approved') {
                $this->processApproved($gp);
            }
        }
    }

    public function processApproved(GatePass $gp): void
    {
        \Illuminate\Support\Facades\Log::info("ProcessApproved called for GatePass ID: " . $gp->id . " Status: " . $gp->status . " Items Count: " . $gp->items()->count());
        
        if ($gp->status !== 'approved') {
            \Illuminate\Support\Facades\Log::warning("GatePass is not approved, skipping stock update.");
            return;
        }

        foreach ($gp->items as $item) {
            \Illuminate\Support\Facades\Log::info("Processing Item ID: " . $item->item_id . " Qty: " . $item->qty_issued);
            $this->updateStock(
                $gp->work_order_id,
                $item->item_id,
                $gp->warehouse_id,
                $item->qty_issued,
                StockLedger::TYPE_GATE_PASS,
                $gp->id,
                $gp->issued_at,
                'qty_issued'
            );
        }
    }
}
