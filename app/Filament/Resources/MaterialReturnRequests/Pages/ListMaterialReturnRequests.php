<?php

namespace App\Filament\Resources\MaterialReturnRequests\Pages;

use App\Filament\Resources\MaterialReturnRequests\MaterialReturnRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialReturnRequests extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = MaterialReturnRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            \pxlrbt\FilamentExcel\Actions\ExportAction::make()
                ->label(__('inventory.export_excel'))
                ->color('success'),
            $this->getPdfExportAction(
                __('inventory.mrrs'),
                [__('inventory.fields.mrr_number'), __('inventory.fields.status'), __('inventory.fields.mrr_date')],
                ['mrr_number', 'status', 'mrr_date'],
                'material-return-requests'
            ),
        ];
    }
}
