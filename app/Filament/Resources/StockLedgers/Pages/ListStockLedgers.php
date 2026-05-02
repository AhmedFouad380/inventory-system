<?php

namespace App\Filament\Resources\StockLedgers\Pages;

use App\Filament\Resources\StockLedgers\StockLedgerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockLedgers extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = StockLedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            \pxlrbt\FilamentExcel\Actions\ExportAction::make()
                ->label(__('inventory.export_excel'))
                ->color('success'),
            $this->getPdfExportAction(
                __('inventory.ledger'),
                [__('inventory.fields.item_code'), __('inventory.fields.type'), __('inventory.fields.qty_in'), __('inventory.fields.qty_out'), __('inventory.fields.balance')],
                ['item.code', 'transaction_type', 'qty_in', 'qty_out', 'balance_after'],
                'stock-ledger'
            ),
        ];
    }
}
