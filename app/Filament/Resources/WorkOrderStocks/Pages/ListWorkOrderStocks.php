<?php

namespace App\Filament\Resources\WorkOrderStocks\Pages;

use App\Filament\Resources\WorkOrderStocks\WorkOrderStockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrderStocks extends ListRecords
{
    protected static string $resource = WorkOrderStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
