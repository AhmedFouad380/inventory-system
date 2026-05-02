<?php

namespace App\Filament\Resources\MaterialReturnRequests\Pages;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialReturnRequests extends ListRecords
{
    protected static string $resource = MaterialReturnRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            \pxlrbt\FilamentExcel\Actions\ExportAction::make()
                ->label(__('inventory.export_excel'))
                ->color('success'),
        ];
    }
}
