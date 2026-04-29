<?php

namespace App\Filament\Resources\MaterialDisposalRequests\Pages;

use App\Filament\Resources\MaterialDisposalRequests\MaterialDisposalRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterialDisposalRequest extends ViewRecord
{
    protected static string $resource = MaterialDisposalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
