<?php

namespace App\Filament\Resources\MaterialDisposalRequests\Pages;

use App\Filament\Resources\MaterialDisposalRequests\MaterialDisposalRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditMaterialDisposalRequest extends EditRecord
{
    protected static string $resource = MaterialDisposalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('status') && $this->record->status === 'approved') {
            (new \App\Observers\MaterialDisposalRequestObserver)->processApproved($this->record);
        }
    }
}
