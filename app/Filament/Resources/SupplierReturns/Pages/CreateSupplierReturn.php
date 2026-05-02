<?php

namespace App\Filament\Resources\SupplierReturns\Pages;

use App\Filament\Resources\SupplierReturns\SupplierReturnResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateSupplierReturn extends CreateRecord
{
    protected static string $resource = SupplierReturnResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $record->load('items');
        
        if ($record->status === 'approved') {
            $observer = new \App\Observers\SupplierReturnObserver();
            $observer->processApproved($record);
        }
    }
}
