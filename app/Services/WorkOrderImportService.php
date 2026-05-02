<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

use App\Models\WorkOrder;
use App\Models\Item;
use App\Models\MaterialReceiptNote;
use App\Models\MrnItem;
use App\Models\GatePass;
use App\Models\GatePassItem;
use App\Models\MaterialReturnRequest;
use App\Models\User;
use App\Jobs\ProcessWorkOrderSheet;
use App\Models\Site;

class WorkOrderImportService
{
    public function import(string $filePath, bool $dryRun = false): array
    {
        $summary = [
            'rows_parsed' => 0,
            'jobs_dispatched' => 0,
            'workorders_created' => 0,
            'mrns_created' => 0,
            'gatepasses_created' => 0,
            'returns_created' => 0,
            'errors' => [],
        ];

        try {
            $sheets = Excel::toArray(null, $filePath);

            foreach ($sheets as $sheetIndex => $rows) {
                // try to read W/O from sheet header
                $workOrderNo = null;
                for ($i = 0; $i < min(10, count($rows)); $i++) {
                    foreach ($rows[$i] as $cell) {
                        if (!$cell) continue;
                        if (preg_match('/W\/?O\s*[:\-]?\s*(\d+)/i', $cell, $m)) {
                            $workOrderNo = trim($m[1]);
                            break 2;
                        }
                    }
                }

                // find header row and map columns for this sheet
                $headerIndex = null;
                $map = [];

                // patterns to match header variations (key => regex)
                $headerPatterns = [
                    'sec' => '/\bSEC\b/i',
                    'description' => '/MATERIAL\s*DESCRIPTION/i',
                    'reservation' => '/RESERVATION/i',
                    'receive_qty' => '/RECEIVE\s*QTY|RECEIVED\s*QTY|QTY\s*RECEIVED/i',
                    'qty_use' => '/QTY\s*USE|QTY\s*USED|ISSUED\s*QTY/i',
                    'balance' => '/BALANCE/i',
                    'date_received' => '/DATE\s*RECEIV|DATE\s*RECEIVED|DATE\s*OF\s*RECEIPT/i',
                    'materialman' => '/MATERIAL\s*MAN|MATERIALMAN/i',
                    'foreman_name' => '/FOREMAN|FOREMAN\s*NAME/i',
                    'date_withdraw' => '/DATE\s*WITHDRAW|DATE\s*WITHDRAWAL|DATE\s*WITHDRAWN/i',
                ];

                foreach ($rows as $i => $row) {
                    $found = 0;
                    foreach ($row as $j => $cell) {
                        if (!$cell) continue;
                        // normalize cell text: trim, collapse spaces
                        $cellNorm = preg_replace('/\s+/', ' ', trim($cell));
                        foreach ($headerPatterns as $key => $pattern) {
                            if (isset($map[$key])) continue; // already found
                            if (preg_match($pattern, $cellNorm)) {
                                $map[$key] = $j;
                                $found++;
                                break;
                            }
                        }
                    }
                    // require at least 3 detected headers to accept this row as header
                    if ($found >= 3) {
                        $headerIndex = $i;
                        break;
                    }
                }

                // if header found, log map for debugging
                if ($headerIndex !== null) {
                    Log::info("WorkOrderImport: detected header map for sheet {$sheetIndex}", $map);
                }

                if ($headerIndex === null) {
                    $summary['errors'][] = "Header row not found in sheet {$sheetIndex}.";
                    continue;
                }

                // collect parsed rows for sheet
                $parsedRows = [];
                for ($r = $headerIndex + 1; $r < count($rows); $r++) {
                    $row = $rows[$r];
                    $sec = $this->getCell($row, $map['sec'] ?? null);
                    $reservation = $this->getCell($row, $map['reservation'] ?? null);
                    if (empty($sec) && empty($reservation)) continue;

                    $parsedRows[] = [
                        'work_order_no' => $workOrderNo,
                        'sec' => $sec,
                        'description' => $this->getCell($row, $map['description'] ?? null),
                        'reservation' => $reservation,
                        'receive_qty' => (float) $this->getCell($row, $map['receive_qty'] ?? null, 0),
                        'qty_use' => (float) $this->getCell($row, $map['qty_use'] ?? null, 0),
                        'balance' => (float) $this->getCell($row, $map['balance'] ?? null, 0),
                        'date_received' => $this->parseDate($this->getCell($row, $map['date_received'] ?? null)),
                        'materialman' => $this->getCell($row, $map['materialman'] ?? null),
                        'foreman_name' => $this->getCell($row, $map['foreman_name'] ?? null),
                        'date_withdraw' => $this->parseDate($this->getCell($row, $map['date_withdraw'] ?? null)),
                    ];
                }

                // update counts and dispatch per-sheet job
                $summary['rows_parsed'] += count($parsedRows);
                if ($dryRun) {
                    foreach ($parsedRows as $data) {
                        $this->simulateRow($data, $summary);
                    }
                } else {
                    // dispatch a job to process the whole sheet
                    ProcessWorkOrderSheet::dispatch($parsedRows, $workOrderNo, $sheetIndex);
                    $summary['jobs_dispatched']++;
                }
            }
        } catch (\Throwable $e) {
            $summary['errors'][] = "File read error: " . $e->getMessage();
            Log::error($e);
        }

        return $summary;
    }

    protected function getCell(array $row, $index, $default = null)
    {
        if ($index === null) return $default;
        return isset($row[$index]) ? trim((string)$row[$index]) : $default;
    }

    protected function parseDate($value)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) {
            try {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->toDateString();
            } catch (\Throwable $e) { }
        }
        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function simulateRow(array $data, array &$summary)
    {
        if ($data['receive_qty'] > 0) $summary['mrns_created']++;
        if ($data['qty_use'] > 0) $summary['gatepasses_created']++;
        if ($data['balance'] > 0) $summary['returns_created']++;
    }

    // The job will call this when processing actual row (not simulation)
    public function processRowFromJob(array $data)
    {
        // ensure users exist
        $materialmanUser = $this->ensureUserByName($data['materialman'] ?? null);
        $foremanUser = $this->ensureUserByName($data['foreman_name'] ?? null);

        // determine site 'Riyadh' if exists
        $site = Site::where('name', 'like', '%Riyadh%')
                    ->orWhere('name', 'like', '%الرياض%')
                    ->first();

        DB::transaction(function() use ($data, $materialmanUser, $foremanUser, $site) {
            // WorkOrder: use wo_number, project_id=1, created_by=1, opened_at = date_received
            $wo = WorkOrder::firstOrCreate(
                ['wo_number' => $data['work_order_no']],
                [
                    'project_id' => 1,
                    'site_id' => $site ? $site->id : null,
                    'supplier_id' => 1,
                    'contract_ref' => $data['first_reservation'] ?? $data['reservation'] ?? null,
                    'opened_at' => $data['date_received'] ?? null,
                    'created_by' => 1,
                    'status' => WorkOrder::STATUS_OPEN,
                ]
            );

            // Item: use item_code = sec
            $item = Item::firstOrCreate(
                ['item_code' => $data['sec']],
                [
                    'name' => $data['description'] ?? null,
                    'description' => $data['description'] ?? null,
                    'created_by' => 1,
                ]
            );

            // MRN: mrn_date = date_received, warehouse_id = 1, prepared_by = materialman
            if (!empty($data['receive_qty']) && $data['receive_qty'] > 0) {
                $mrn = MaterialReceiptNote::firstOrCreate(
                    ['work_order_id' => $wo->id, 'mrn_date' => $data['date_received']],
                    [
                        'mrn_number' => 'MRN-'.strtoupper(substr(sha1(uniqid()),0,12)),
                        'reservation_number' => $data['reservation'] ?? null,
                        'prepared_by' => $materialmanUser ? $materialmanUser->id : 1,
                        'warehouse_keeper_id' => $materialmanUser ? $materialmanUser->id : null,
                        // ensure imported MRNs are linked to supplier_id = 1
                        'supplier_id' => 1,
                        'status' => MaterialReceiptNote::STATUS_DRAFT,
                        'warehouse_id' => 1,
                    ]
                );

                MrnItem::firstOrCreate(
                    ['mrn_id' => $mrn->id, 'item_id' => $item->id],
                    ['qty_received' => $data['receive_qty']]
                );
            }

            // GatePass: gp_number, issued_at (date_withdraw or mrn date), prepared_by = materialman, warehouse_id=1
            if (!empty($data['qty_use']) && $data['qty_use'] > 0) {
                $gp = GatePass::create([
                    'gp_number' => 'GP-'.strtoupper(substr(sha1(uniqid()),0,10)),
                    'work_order_id' => $wo->id,
                    'issued_at' => $data['date_withdraw'] ?? ($data['date_received'] ?? now()),
                    'prepared_by' => $materialmanUser ? $materialmanUser->id : 1,
                    'warehouse_keeper_id' => $materialmanUser ? $materialmanUser->id : null,
                    'status' => GatePass::STATUS_ISSUED,
                    'warehouse_id' => 1,
                ]);

                GatePassItem::create([
                    'gate_pass_id' => $gp->id,
                    'item_id' => $item->id,
                    'qty_issued' => $data['qty_use']
                ]);
            }

            // Material Return Request (MRR): create MRR then MrrItem
            if (!empty($data['balance']) && $data['balance'] > 0) {
                $mrr = MaterialReturnRequest::create([
                    'mrr_number' => 'MRR-'.strtoupper(substr(sha1(uniqid()),0,10)),
                    'work_order_id' => $wo->id,
                    'mrr_date' => $data['date_received'] ?? now(),
                    'return_to' => null,
                    // set supplier for returns as well
                    'supplier_id' => 1,
                    'status' => MaterialReturnRequest::STATUS_DRAFT,
                    'prepared_by' => $foremanUser ? $foremanUser->id : 1,
                    'warehouse_id' => 1,
                ]);

                // create mrr item (mrr_items table)
                \App\Models\MrrItem::create([
                    'mrr_id' => $mrr->id,
                    'item_id' => $item->id,
                    'qty_returned' => $data['balance'],
                ]);
            }
        });
    }

    protected function ensureUserByName(?string $name)
    {
        if (empty($name)) return null;
        $clean = mb_strtolower(trim($name));
        $clean = preg_replace('/[^a-z0-9\.\-\_]/u', '.', $clean);
        $clean = preg_replace('/[\.\-\_]{2,}/', '.', $clean);
        $clean = trim($clean, '.');
        if (empty($clean)) $clean = 'user'.uniqid();
        $email = $clean . '@gmail.com';

        $user = User::where('email', $email)->first();
        if ($user) return $user;

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('123456'),
        ]);
    }
}
