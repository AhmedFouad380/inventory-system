<?php

namespace App\Filament\Resources\MaterialReceiptNotes\Pages;

use App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialReceiptNotes extends ListRecords
{
    protected static string $resource = MaterialReceiptNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
