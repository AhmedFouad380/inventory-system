<?php

namespace App\Filament\Resources\MaterialReturnRequests\Pages;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateMaterialReturnRequest extends CreateRecord
{
    protected static string $resource = MaterialReturnRequestResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        $mrr = $this->record;
        $mrr->load('items');
        
        if ($mrr->status === 'approved') {
            $observer = new \App\Observers\MaterialReturnRequestObserver();
            $observer->processApproved($mrr);
        }
    }
}
