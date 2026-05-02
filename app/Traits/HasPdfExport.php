<?php

namespace App\Traits;

use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

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
                
                $rows = $data->map(function ($item) use ($columnMapping) {
                    $row = [];
                    foreach ($columnMapping as $field) {
                        // Handle nested relations like 'workOrder.wo_number'
                        $value = data_get($item, $field);
                        
                        // Format dates if they are instances of Carbon
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
            });
    }
}
