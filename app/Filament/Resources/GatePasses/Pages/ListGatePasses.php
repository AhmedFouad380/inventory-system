<?php

namespace App\Filament\Resources\GatePasses\Pages;

use App\Filament\Resources\GatePasses\GatePassResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGatePasses extends ListRecords
{
    use \App\Traits\HasPdfExport;

    protected static string $resource = GatePassResource::class;

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
            //     __('inventory.gate_passes'),
            //     [__('inventory.fields.gp_number'), __('inventory.fields.status'), __('inventory.fields.issued_at')],
            //     ['gp_number', 'status', 'issued_at'],
            //     'gate-passes'
            // ),
        ];
    }
}
