<?php

namespace App\Filament\Resources\WorkOrderStocks\Pages;

use App\Filament\Resources\WorkOrderStocks\WorkOrderStockResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkOrderStock extends EditRecord
{
    protected static string $resource = WorkOrderStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
