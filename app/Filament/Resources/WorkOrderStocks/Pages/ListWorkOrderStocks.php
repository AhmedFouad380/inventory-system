<?php

namespace App\Filament\Resources\WorkOrderStocks\Pages;

use App\Filament\Resources\WorkOrderStocks\WorkOrderStockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrderStocks extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = WorkOrderStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            \pxlrbt\FilamentExcel\Actions\ExportAction::make()
                ->label(__('inventory.export_excel'))
                ->color('success'),
            $this->getPdfExportAction(
                __('inventory.stock'),
                [__('inventory.item'), __('inventory.warehouse'), __('inventory.fields.balance')],
                ['item.description', 'warehouse.name', 'balance'],
                'stock-balance'
            ),
        ];
    }
}
