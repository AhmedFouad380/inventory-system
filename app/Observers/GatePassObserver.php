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
        if ($gp->status === 'approved') {
            $this->processApproved($gp);
        }
    }

    public function updated(GatePass $gp): void
    {
        if ($gp->isDirty('status') && $gp->status === 'approved') {
            $this->processApproved($gp);
        }
    }

    private function processApproved(GatePass $gp): void
    {
        foreach ($gp->items as $item) {
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
