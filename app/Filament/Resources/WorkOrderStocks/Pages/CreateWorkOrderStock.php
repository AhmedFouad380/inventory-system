<?php

namespace App\Filament\Resources\WorkOrderStocks\Pages;

use App\Filament\Resources\WorkOrderStocks\WorkOrderStockResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkOrderStock extends CreateRecord
{
    protected static string $resource = WorkOrderStockResource::class;
}
