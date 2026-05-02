<?php

namespace App\Filament\Resources\GatePasses\Pages;

use App\Filament\Resources\GatePasses\GatePassResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditGatePass extends EditRecord
{
    protected static string $resource = GatePassResource::class;

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
        $gp = $this->record;
        $gp->load('items');
        \Illuminate\Support\Facades\Log::info("EditGatePass afterSave called for ID: " . $gp->id . " Status: " . $gp->status);
        
        if ($gp->status === 'approved') {
            $exists = \App\Models\StockLedger::where('transaction_type', \App\Models\StockLedger::TYPE_GATE_PASS)
                ->where('transaction_id', $gp->id)
                ->exists();
                
            if (!$exists) {
                \Illuminate\Support\Facades\Log::info("GatePass approved and not in ledger, processing...");
                $observer = new \App\Observers\GatePassObserver();
                $observer->processApproved($gp);
            } else {
                \Illuminate\Support\Facades\Log::info("GatePass already processed in ledger.");
            }
        }
    }
}
