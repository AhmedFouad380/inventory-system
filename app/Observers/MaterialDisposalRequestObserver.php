<?php

namespace App\Observers;

use App\Models\MaterialDisposalRequest;
use App\Models\StockLedger;
use App\Traits\HandlesStock;

class MaterialDisposalRequestObserver
{
    use HandlesStock;

    public function processApproved(MaterialDisposalRequest $mdr): void
    {
        foreach ($mdr->items as $item) {
            $this->updateStock(
                $mdr->work_order_id,
                $item->item_id,
                $mdr->warehouse_id,
                $item->qty_disposed,
                StockLedger::TYPE_MDR,
                $mdr->id,
                $mdr->mdr_date,
                'qty_disposed'
            );
        }
    }
}
