<?php

namespace App\Filament\Resources\Drivers\Pages;

use App\Filament\Resources\Drivers\DriverResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListDrivers extends ListRecords
{
    protected static string $resource = DriverResource::class;

      protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
