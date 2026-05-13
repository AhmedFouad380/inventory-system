<?php

namespace App\Filament\Resources\WorkOrders\Pages;

use App\Filament\Resources\WorkOrders\WorkOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrders extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = WorkOrderResource::class;
  public ?int $year = null;

    protected $queryString = [
        'year' => ['except' => null],
    ];

    public function mount(): void
    {
        parent::mount();

        $this->year = request()->integer('year') ?: null;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            // \pxlrbt\FilamentExcel\Actions\ExportAction::make()
            //     ->label(__('inventory.export_excel'))
            //     ->color('success'),
            // $this->getPdfExportAction(
            //     __('inventory.work_orders'),
            //     [__('inventory.fields.wo_number'), __('inventory.fields.status'), __('inventory.fields.opened_at')],
            //     ['wo_number', 'status', 'opened_at'],
            //     'work-orders'
            // ),
        ];
    }
}
