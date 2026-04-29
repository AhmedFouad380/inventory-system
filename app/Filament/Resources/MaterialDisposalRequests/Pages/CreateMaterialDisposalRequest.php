<?php

namespace App\Filament\Resources\MaterialDisposalRequests\Pages;

use App\Filament\Resources\MaterialDisposalRequests\MaterialDisposalRequestResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateMaterialDisposalRequest extends CreateRecord
{
    protected static string $resource = MaterialDisposalRequestResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        if ($this->record->status === 'approved') {
            (new \App\Observers\MaterialDisposalRequestObserver)->processApproved($this->record);
        }
    }
}
