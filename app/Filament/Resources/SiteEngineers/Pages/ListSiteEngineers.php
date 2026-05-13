<?php

namespace App\Filament\Resources\SiteEngineers\Pages;

use App\Filament\Resources\SiteEngineers\SiteEngineersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteEngineers extends ListRecords
{
    protected static string $resource = SiteEngineersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
