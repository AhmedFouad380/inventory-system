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
}
