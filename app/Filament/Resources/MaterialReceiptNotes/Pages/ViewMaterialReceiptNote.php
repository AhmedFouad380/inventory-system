<?php

namespace App\Filament\Resources\MaterialReceiptNotes\Pages;

use App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterialReceiptNote extends ViewRecord
{
    protected static string $resource = MaterialReceiptNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
