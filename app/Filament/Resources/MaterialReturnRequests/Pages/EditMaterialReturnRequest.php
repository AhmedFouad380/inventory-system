<?php

namespace App\Filament\Resources\MaterialReturnRequests\Pages;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditMaterialReturnRequest extends EditRecord
{
    protected static string $resource = MaterialReturnRequestResource::class;

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
        $mrr = $this->record->refresh();
        $mrr->load('items');
        
        if ($mrr->status === 'approved') {
            $exists = \App\Models\StockLedger::where('transaction_type', \App\Models\StockLedger::TYPE_MRR)
                ->where('transaction_id', $mrr->id)
                ->exists();
                
            if (!$exists) {
                $observer = new \App\Observers\MaterialReturnRequestObserver();
                $observer->processApproved($mrr);
            }
        }
    }
}
