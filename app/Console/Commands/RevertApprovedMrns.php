<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaterialReceiptNote;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RevertApprovedMrns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mrn:revert-approved {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revert all approved MRNs back to draft (clears approved_by and approved_at).';

    public function handle()
    {
        $chunk = (int) $this->option('chunk');

        $toRevert = MaterialReceiptNote::where('status', 'approved')->count();
        $this->info("Approved MRNs to revert: $toRevert");

        $processed = 0;
        $failed = 0;

        MaterialReceiptNote::where('status', 'approved')
            ->orderBy('id')
            ->chunk($chunk, function ($rows) use (&$processed, &$failed) {
                foreach ($rows as $mrn) {
                    try {
                        DB::transaction(function () use ($mrn) {
                            $m = MaterialReceiptNote::lockForUpdate()->find($mrn->id);
                            if (! $m) return;

                            $m->status = 'draft';
                            $m->approved_by = null;
                            $m->approved_at = null;
                            $m->save();
                        });
                        $processed++;
                        if ($processed % 50 === 0) {
                            $this->info("Reverted: $processed");
                        }
                        file_put_contents(storage_path('logs/mrn_reverted.log'), "reverted: {$mrn->id}\n", FILE_APPEND);
                    } catch (\Throwable $e) {
                        $failed++;
                        $msg = "Failed reverting MRN id={$mrn->id}: " . $e->getMessage();
                        Log::error($msg, ['exception' => $e]);
                        file_put_contents(storage_path('logs/mrn_revert_failures.log'), $msg."\n", FILE_APPEND);
                    }
                }
            });

        $this->info("Done. Reverted: $processed. Failed: $failed.");
        return 0;
    }
}
