<?php

namespace App\Filament\Resources\MaterialReceiptNotes\Pages;

use App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditMaterialReceiptNote extends EditRecord
{
    protected static string $resource = MaterialReceiptNoteResource::class;

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
        $mrn = $this->record->refresh();
        $mrn->load('items');
        
        if ($mrn->status === 'approved') {
            $exists = \App\Models\StockLedger::where('transaction_type', \App\Models\StockLedger::TYPE_MRN)
                ->where('transaction_id', $mrn->id)
                ->exists();
                
            if (!$exists) {
                $observer = new \App\Observers\MaterialReceiptNoteObserver();
                $observer->processApproved($mrn);
            }
        }
    }
}
