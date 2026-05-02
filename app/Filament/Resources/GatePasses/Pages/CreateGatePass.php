<?php

namespace App\Filament\Resources\GatePasses\Pages;

use App\Filament\Resources\GatePasses\GatePassResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateGatePass extends CreateRecord
{
    protected static string $resource = GatePassResource::class;

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::Full;
    }

    protected function afterCreate(): void
    {
        $gp = $this->record;
        $gp->load('items');
        \Illuminate\Support\Facades\Log::info("CreateGatePass afterCreate called for ID: " . $gp->id . " Status: " . $gp->status);
        
        if ($gp->status === 'approved') {
            $observer = new \App\Observers\GatePassObserver();
            $observer->processApproved($gp);
        }
    }
}
