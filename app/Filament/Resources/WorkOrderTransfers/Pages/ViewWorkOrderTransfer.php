<?php

namespace App\Filament\Resources\WorkOrderTransfers\Pages;

use App\Filament\Resources\WorkOrderTransfers\WorkOrderTransferResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkOrderTransfer extends ViewRecord
{
    protected static string $resource = WorkOrderTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
