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
}
