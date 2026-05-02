<?php

namespace App\Filament\Resources\SupplierReturns\Pages;

use App\Filament\Resources\SupplierReturns\SupplierReturnResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditSupplierReturn extends EditRecord
{
    protected static string $resource = SupplierReturnResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()->hidden(fn ($record) => $record?->status === 'approved'),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $record->load('items');
        
        if ($record->status === 'approved') {
            $observer = new \App\Observers\SupplierReturnObserver();
            $observer->processApproved($record);
        }
    }
}
