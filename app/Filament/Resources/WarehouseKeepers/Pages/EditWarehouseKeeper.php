<?php

namespace App\Filament\Resources\WarehouseKeepers\Pages;

use App\Filament\Resources\WarehouseKeepers\WarehouseKeeperResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditWarehouseKeeper extends EditRecord
{
    protected static string $resource = WarehouseKeeperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
