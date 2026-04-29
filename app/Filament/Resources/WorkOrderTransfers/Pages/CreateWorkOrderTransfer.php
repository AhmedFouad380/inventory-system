<?php

namespace App\Filament\Resources\WorkOrderTransfers\Pages;

use App\Filament\Resources\WorkOrderTransfers\WorkOrderTransferResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateWorkOrderTransfer extends CreateRecord
{
    protected static string $resource = WorkOrderTransferResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        $transfer = $this->record;
        
        $transfer->load('items');
        
        if ($transfer->status === 'approved') {
            $observer = new \App\Observers\WorkOrderTransferObserver();
            $observer->processApproved($transfer);
        }
    }
}
