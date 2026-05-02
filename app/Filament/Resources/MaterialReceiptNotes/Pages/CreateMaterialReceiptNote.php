<?php

namespace App\Filament\Resources\MaterialReceiptNotes\Pages;

use App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateMaterialReceiptNote extends CreateRecord
{
    protected static string $resource = MaterialReceiptNoteResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        $mrn = $this->record;
        $mrn->load('items');
        
        if ($mrn->status === 'approved') {
            $observer = new \App\Observers\MaterialReceiptNoteObserver();
            $observer->processApproved($mrn);
        }
    }
}
