<?php

namespace App\Filament\Resources\SupplierReturns\Pages;

use App\Filament\Resources\SupplierReturns\SupplierReturnResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\MaxWidth;

class ViewSupplierReturn extends ViewRecord
{
    protected static string $resource = SupplierReturnResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->hidden(fn ($record) => $record?->status === 'approved'),
        ];
    }
}
