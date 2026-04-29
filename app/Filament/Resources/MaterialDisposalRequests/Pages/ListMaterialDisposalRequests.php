<?php

namespace App\Filament\Resources\MaterialDisposalRequests\Pages;

use App\Filament\Resources\MaterialDisposalRequests\MaterialDisposalRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialDisposalRequests extends ListRecords
{
    protected static string $resource = MaterialDisposalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
