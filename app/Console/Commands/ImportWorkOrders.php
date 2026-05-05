<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WorkOrderImportService;

class ImportWorkOrders extends Command
{
    protected $signature = 'import:workorders {file? : path to Excel file} {--dry-run : do not write to DB}';
    protected $description = 'Import work orders from Excel and create MRN, GatePass and Returns using queued jobs';

    public function handle()
    {
        $file = $this->argument('file') ?? public_path('2026 ALL SEC WORK ORDER.xlsx');
        $dryRun = $this->option('dry-run');

        $this->info("Import starting (dry-run: " . ($dryRun ? 'yes' : 'no') . ")");
        $this->info("Reading file: {$file}");

        $service = new WorkOrderImportService();
        $result = $service->import($file, $dryRun);

        $this->info("Import finished:");
        $this->info("Rows parsed: " . ($result['rows_parsed'] ?? 0));
        $this->info("Jobs dispatched: " . ($result['jobs_dispatched'] ?? 0));
        $this->info("WorkOrders (created during simulation): " . ($result['workorders_created'] ?? 0));
        $this->info("MRNs (simulation): " . ($result['mrns_created'] ?? 0));
        $this->info("GatePasses (simulation): " . ($result['gatepasses_created'] ?? 0));
        $this->info("Returns (simulation): " . ($result['returns_created'] ?? 0));

        if (!empty($result['errors'])) {
            $this->error('Errors:');
            foreach ($result['errors'] as $err) {
                $this->line("- {$err}");
            }
        }

        return 0;
    }
}
