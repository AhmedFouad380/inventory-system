<?php

namespace App\Filament\Resources\WorkOrderStocks\Pages;

use App\Filament\Resources\WorkOrderStocks\WorkOrderStockResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkOrderStock extends ViewRecord
{
    protected static string $resource = WorkOrderStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
