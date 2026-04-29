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
}
