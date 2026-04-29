<?php

namespace App\Filament\Resources\WorkOrderTransfers\Pages;

use App\Filament\Resources\WorkOrderTransfers\WorkOrderTransferResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditWorkOrderTransfer extends EditRecord
{
    protected static string $resource = WorkOrderTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterSave(): void
    {
        $transfer = $this->record;
        
        $transfer->load('items');
        
        // Only process if status changed to approved
        if ($transfer->wasChanged('status') && $transfer->status === 'approved') {
            $observer = new \App\Observers\WorkOrderTransferObserver();
            $observer->processApproved($transfer);
        }
    }
}
