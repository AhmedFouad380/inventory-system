<?php

namespace App\Traits;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

trait HasPdfExport
{
    protected function getPdfExportAction(string $title, array $headers, array $columnMapping, string $fileName): Action
    {
        return Action::make('export_pdf')
            ->label('تصدير PDF')
            ->color('danger')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function () use ($title, $headers, $columnMapping, $fileName) {
                $data = $this->getFilteredTableQuery()->get();
                return $this->generatePdfResponse($title, $headers, $columnMapping, $fileName, $data);
            });
    }

    protected function getPdfBulkExportAction(string $title, array $headers, array $columnMapping, string $fileName): BulkAction
    {
        return BulkAction::make('export_pdf_bulk')
            ->label('تصدير PDF')
            ->color('danger')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (Collection $records) use ($title, $headers, $columnMapping, $fileName) {
                return $this->generatePdfResponse($title, $headers, $columnMapping, $fileName, $records);
            });
    }

    protected function generatePdfResponse(string $title, array $headers, array $columnMapping, string $fileName, $data)
    {
        $rows = $data->map(function ($item) use ($columnMapping) {
            $row = [];
            foreach ($columnMapping as $field) {
                $value = data_get($item, $field);
                
                if ($value instanceof \Carbon\Carbon) {
                    $value = $value->format('Y-m-d');
                }
                
                $row[] = $value;
            }
            return $row;
        })->toArray();

        $pdf = Pdf::loadView('pdf.inventory-report', [
            'title' => $title,
            'headers' => $headers,
            'data' => $rows,
        ]);

        return response()->streamDownload(fn () => print($pdf->output()), $fileName . '.pdf');
    }
}
