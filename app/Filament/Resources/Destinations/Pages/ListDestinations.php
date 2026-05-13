<?php

namespace App\Filament\Resources\Destinations\Pages;

use App\Filament\Resources\Destinations\DestinationResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
class ListDestinations extends ListRecords
{
    protected static string $resource = DestinationResource::class;
       protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
