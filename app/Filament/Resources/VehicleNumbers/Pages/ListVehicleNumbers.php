<?php

namespace App\Filament\Resources\VehicleNumbers\Pages;

use App\Filament\Resources\VehicleNumbers\VehicleNumberResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
class ListVehicleNumbers extends ListRecords
{
    protected static string $resource = VehicleNumberResource::class;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
