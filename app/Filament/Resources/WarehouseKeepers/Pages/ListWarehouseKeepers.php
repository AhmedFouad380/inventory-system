<?php

namespace App\Filament\Resources\WarehouseKeepers\Pages;

use App\Filament\Resources\WarehouseKeepers\WarehouseKeeperResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWarehouseKeepers extends ListRecords
{
    protected static string $resource = WarehouseKeeperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
