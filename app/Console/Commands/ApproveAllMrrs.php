<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaterialReturnRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApproveAllMrrs extends Command
{
    protected $signature = 'mrr:approve-all {--dry-run} {--chunk=100}';
    protected $description = 'Approve all Material Return Requests so observers run and stock is updated.';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $chunk = (int) $this->option('chunk');

        $toApprove = MaterialReturnRequest::where('status', '!=', 'approved')->count();
        $this->info("MRRs to approve: $toApprove");

        if ($dry) {
            $this->info('Dry run complete.');
            return 0;
        }

        $processed = 0; $failed = 0;

        MaterialReturnRequest::where('status', '!=', 'approved')
            ->orderBy('id')
            ->chunk($chunk, function ($rows) use (&$processed, &$failed) {
                foreach ($rows as $mrr) {
                    try {
                        DB::transaction(function () use ($mrr) {
                            $r = MaterialReturnRequest::lockForUpdate()->find($mrr->id);
                            if (! $r) return;

                            $r->status = 'approved';
                            $r->save();
                        });
                        $processed++;
                        if ($processed % 50 === 0) $this->info("Approved: $processed");
                    } catch (\Throwable $e) {
                        $failed++;
                        $msg = "Failed approving MRR id={$mrr->id}: " . $e->getMessage();
                        Log::error($msg, ['exception' => $e]);
                        file_put_contents(storage_path('logs/mrr_approve_failures.log'), $msg."\n", FILE_APPEND);
                    }
                }
            });

        $this->info("Done. Approved: $processed. Failed: $failed.");
        return 0;
    }
}
