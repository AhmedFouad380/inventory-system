<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GatePass;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApproveAllGatePasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gp:approve-all {--dry-run} {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve all GatePasses so observers run and stock is updated. Use --dry-run to only report counts.';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $chunk = (int) $this->option('chunk');

        $toApprove = GatePass::where('status', '!=', 'approved')->count();
        $this->info("GatePasses to approve: $toApprove");

        if ($dry) {
            $this->info('Dry run complete. No updates performed.');
            return 0;
        }

        $processed = 0;
        $failed = 0;

        GatePass::where('status', '!=', 'approved')
            ->orderBy('id')
            ->chunk($chunk, function ($rows) use (&$processed, &$failed) {
                foreach ($rows as $gp) {
                    try {
                        DB::transaction(function () use ($gp) {
                            $g = GatePass::lockForUpdate()->find($gp->id);
                            if (! $g) return;

                            $g->status = 'approved';
                            // $g->approved_by = 1;
                            // $g->approved_at = Carbon::now();
                            $g->save();
                        });

                        $processed++;
                        if ($processed % 50 === 0) {
                            $this->info("Approved: $processed");
                        }
                    } catch (\Throwable $e) {
                        $failed++;
                        $msg = "Failed approving GatePass id={$gp->id}: " . $e->getMessage();
                        Log::error($msg, ['exception' => $e]);
                        file_put_contents(storage_path('logs/gp_approve_failures.log'), $msg."\n", FILE_APPEND);
                    }
                }
            });

        $this->info("Done. Approved: $processed. Failed: $failed.");
        return 0;
    }
}
