<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Services\WorkOrderImportService;

class ProcessWorkOrderSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rows;
    public $workOrderNo;
    public $sheetIndex;

    public function __construct(array $rows, $workOrderNo = null, $sheetIndex = 0)
    {
        $this->rows = $rows;
        $this->workOrderNo = $workOrderNo;
        $this->sheetIndex = $sheetIndex;
    }

    public function handle()
    {
        $service = new WorkOrderImportService();

        // determine first reservation number for this sheet
        $firstReservation = null;
        foreach ($this->rows as $r) {
            if (!empty($r['reservation'])) {
                $firstReservation = $r['reservation'];
                break;
            }
        }

        foreach ($this->rows as $index => $row) {
            // attach first_reservation to row
            $row['first_reservation'] = $firstReservation;

            // log raw row for debugging and append to dedicated log file
            try {
                $logData = ['sheet' => $this->sheetIndex, 'index' => $index, 'row' => $row];
                Log::info('WorkOrderImport: processing row', $logData);
                // append to storage/logs/import_rows.log for easier inspection
                file_put_contents(storage_path('logs/import_rows.log'), json_encode($logData, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);

                // optional immediate dump for interactive debugging
                if (env('IMPORT_DEBUG', false)) {
                    dd($logData);
                }

                $service->processRowFromJob($row);
            } catch (\Throwable $e) {
                Log::error("ProcessWorkOrderSheet error on sheet {$this->sheetIndex} row {$index}: " . $e->getMessage(), ['exception' => $e, 'row' => $row]);
                // continue with next row
            }
        }
    }
}
