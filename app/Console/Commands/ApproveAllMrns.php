<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaterialReceiptNote;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApproveAllMrns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mrn:approve-all {--dry-run} {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve all Material Receipt Notes (MRNs) so observers run and stock is updated. Use --dry-run to only report counts.';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $chunk = (int) $this->option('chunk');

        $toApprove = MaterialReceiptNote::where('status', '!=', 'approved')->count();
        $this->info("MRNs to approve: $toApprove");

        if ($dry) {
            $this->info('Dry run complete. No updates performed.');
            return 0;
        }

        $processed = 0;
        $failed = 0;

        MaterialReceiptNote::where('status', '!=', 'approved')
            ->orderBy('id')
            ->chunk($chunk, function ($rows) use (&$processed, &$failed) {
                foreach ($rows as $mrn) {
                    try {
                        DB::transaction(function () use ($mrn) {
                            // reload inside transaction to avoid stale relations
                            $m = MaterialReceiptNote::lockForUpdate()->find($mrn->id);
                            if (! $m) return;

                            $m->status = 'approved';
                            $m->approved_by = 1;
                            $m->approved_at = Carbon::now();
                            $m->save();
                        });
                        $processed++;
                        if ($processed % 50 === 0) {
                            $this->info("Approved: $processed");
                        }
                    } catch (\Throwable $e) {
                        $failed++;
                        $msg = "Failed approving MRN id={$mrn->id}: " . $e->getMessage();
                        Log::error($msg, ['exception' => $e]);
                        file_put_contents(storage_path('logs/mrn_approve_failures.log'), $msg."\n", FILE_APPEND);
                    }
                }
            });

        $this->info("Done. Approved: $processed. Failed: $failed.");
        return 0;
    }
}
