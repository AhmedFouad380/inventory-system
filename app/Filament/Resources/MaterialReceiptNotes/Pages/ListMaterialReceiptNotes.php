<?php

namespace App\Filament\Resources\MaterialReceiptNotes\Pages;

use App\Filament\Resources\MaterialReceiptNotes\MaterialReceiptNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialReceiptNotes extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = MaterialReceiptNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            // \pxlrbt\FilamentExcel\Actions\ExportAction::make()
            //     ->label(__('inventory.export_excel'))
            //     ->color('success'),
            // $this->getPdfExportAction(
            //     __('inventory.mrns'),
            //     [__('inventory.fields.mrn_number'), __('inventory.fields.status'), __('inventory.fields.mrn_date')],
            //     ['mrn_number', 'status', 'mrn_date'],
            //     'material-receipt-notes'
            // ),
        ];
    }
}
