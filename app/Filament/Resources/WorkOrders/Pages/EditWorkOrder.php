<?php

namespace App\Filament\Resources\WorkOrders\Pages;

use App\Filament\Resources\WorkOrders\WorkOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkOrder extends EditRecord
{
    protected static string $resource = WorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $wo = $this->record;
        $wo->load('materialReceiptNotes.items');
        
        foreach ($wo->materialReceiptNotes as $mrn) {
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
}
