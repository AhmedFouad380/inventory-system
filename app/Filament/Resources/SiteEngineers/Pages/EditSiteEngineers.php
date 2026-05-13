<?php

namespace App\Filament\Resources\SiteEngineers\Pages;

use App\Filament\Resources\SiteEngineers\SiteEngineersResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteEngineers extends EditRecord
{
    protected static string $resource = SiteEngineersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
