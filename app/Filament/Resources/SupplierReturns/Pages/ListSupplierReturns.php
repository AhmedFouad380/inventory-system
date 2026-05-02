<?php

namespace App\Filament\Resources\SupplierReturns\Pages;

use App\Filament\Resources\SupplierReturns\SupplierReturnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupplierReturns extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = SupplierReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            \pxlrbt\FilamentExcel\Actions\ExportAction::make()
                ->label(__('inventory.export_excel'))
                ->color('success'),
            $this->getPdfExportAction(
                __('inventory.supplier_returns'),
                [__('inventory.fields.sr_number'), __('inventory.fields.status'), __('inventory.fields.return_date')],
                ['return_number', 'status', 'return_date'],
                'supplier-returns'
            ),
        ];
    }
}
