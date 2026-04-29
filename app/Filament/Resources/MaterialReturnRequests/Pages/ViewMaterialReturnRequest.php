<?php

namespace App\Filament\Resources\MaterialReturnRequests\Pages;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterialReturnRequest extends ViewRecord
{
    protected static string $resource = MaterialReturnRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
