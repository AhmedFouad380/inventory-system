<?php

namespace App\Filament\Resources\Recipients\Pages;

use App\Filament\Resources\Recipients\RecipientResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListRecipients extends ListRecords
{
    protected static string $resource = RecipientResource::class;

      protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
