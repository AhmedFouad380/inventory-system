<?php

namespace App\Filament\Resources\WorkOrderTransfers\Pages;

use App\Filament\Resources\WorkOrderTransfers\WorkOrderTransferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrderTransfers extends ListRecords
{
    protected static string $resource = WorkOrderTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
