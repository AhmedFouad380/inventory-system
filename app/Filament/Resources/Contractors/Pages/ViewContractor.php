<?php

namespace App\Filament\Resources\Contractors\Pages;

use App\Filament\Resources\Contractors\ContractorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContractor extends ViewRecord
{
    protected static string $resource = ContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
