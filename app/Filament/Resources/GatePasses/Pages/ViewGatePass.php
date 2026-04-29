<?php

namespace App\Filament\Resources\GatePasses\Pages;

use App\Filament\Resources\GatePasses\GatePassResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGatePass extends ViewRecord
{
    protected static string $resource = GatePassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
