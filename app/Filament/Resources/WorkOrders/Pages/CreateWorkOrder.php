<?php

namespace App\Filament\Resources\WorkOrders\Pages;

use App\Filament\Resources\WorkOrders\WorkOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkOrder extends CreateRecord
{
    protected static string $resource = WorkOrderResource::class;
    protected function afterCreate(): void
    {
        $wo = $this->record;
        $wo->load('materialReceiptNotes.items');
        
        foreach ($wo->materialReceiptNotes as $mrn) {
            if ($mrn->status === 'approved') {
                $observer = new \App\Observers\MaterialReceiptNoteObserver();
                $observer->processApproved($mrn);
            }
        }
    }
}
