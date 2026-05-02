Plan 1

ملخص تنفيذي (مختصر وقابل للتنفيذ):

الهدف: استيراد بيانات أوامر العمل من ملف الإكسل `public/2025 ALL SEC WORK ORDER.xlsx` وإنشاء WorkOrder + MaterialReceiptNote (MRN) + GatePass + MaterialReturnRequest حسب الأعمدة.

موقع رقم أمر العمل في الإكسل:
- رقم أمر العمل ظاهر كـ W/O في الهيدر الأخضر على يمين الورقة (خانة كبيرة باللون الأخضر، كما في الصورة المرفقة)، هذا الرقم يستخدم لتجميع كل السطور المتعلقة بنفس أمر العمل.

خريطة الأعمدة (من الملف):
- S/R # → مسلسلي داخل ملف.
- SEC → كود المنتج (نستخدمه للبحث عن Item). 
- MATERIAL DESCRIPTION → اسم المنتج (يستخدم إذا الكود غير موجود لإنشاء Item).
- RESERVATION → رقم الحجز (يربط MRN/Receipt).
- RECEIVE QTY → كمية الاستلام (تُسجل في MRN items).
- QTY USE → الكمية المستخدمة (تُستخدم لإنشاء GatePass/صرف تنفيذ).
- BALANCE → الرصيد المتبقي (إن >0 نعمل طلب إرجاع للمخزن).
- DATE RECEIVED → تاريخ MRN.
- MATERIALMAN → أمين المخزن (نطابق User أو نخزن كنص إن لم يوجد).
- FOREMAN NAME → اسم المشرف (يحفظ في WorkOrder).
- DATE WITHDRAW → تاريخ السحب (تاريخ تنفيذ/صرف).

خطوات التنفيذ التقنية:
1. قراءة الإكسل: استخدام maatwebsite/excel أو PhpSpreadsheet.
2. تنظيف وتحويل القيم: trim، تحويل أرقام وكميات، توحيد تواريخ (Y-m-d).
3. تجميع حسب Work Order No (القيمة الموجودة بالهيدر الأخضر).
4. لكل WorkOrder (داخل DB::transaction):
   - findOrCreate WorkOrder (املأ foreman, date_withdraw إن وُجد).
   - لكل صف/رقم reservation داخل WorkOrder:
     - findOrCreate Item by `SEC`، وإن لم يوجد فأنشئ باستخدام `MATERIAL DESCRIPTION`.
     - findOrCreate أو أنشئ MaterialReceiptNote مرتبط بالـ reservation وdate_received، وأضف MRN item مع `received_qty`.
     - أنشئ GatePass/GatePassItem بالكمية `qty_use`، مرتبط بالـ WorkOrder وItem (date = date_withdraw).
     - إن balance > 0 فأنشئ MaterialReturnRequest بالكمية المتبقية.
5. قواعد سلامة البيانات:
   - تنفيذ ضمن DB::transaction لكل WorkOrder.
   - تحقق من idempotency: تجنب إنشاء سجلات مكررة (تفحص reservation+item+date).
   - سجل الأخطاء في `storage/logs/import-workorders.log`.
6. واجهة التنفيذ:
   - Artisan command: `php artisan import:workorders {file?} {--dry-run}` (الملف الافتراضي: `public/2025 ALL SEC WORK ORDER.xlsx`).
   - خيارات: `--dry-run` لعرض التغييرات بدون حفظ.
7. مخرجات بعد التشغيل:
   - ملخص: عدد WorkOrders/ MRNs/ GatePasses/ Returns المنشأة + قائمة الأخطاء.

مثال مصغر على تمثيل صف بعد الـ parsing (PHP array):

[
  'work_order_no' => 'W/O 243039104',
  'sec' => '908020201',
  'description' => 'LOCK PAD',
  'reservation' => '26540726',
  'receive_qty' => 1,
  'qty_use' => 0,
  'balance' => 1,
  'date_received' => '2025-08-01',
  'materialman' => 'Ahmed Ali',
  'foreman_name' => 'Mohamed Salah',
  'date_withdraw' => '2025-08-02'
]

ملاحظات أخيرة:
- الصورة المرسلة تُظهر مكان رقم أمر العمل (الهيدر الأخضر، أعلى اليمين). يجب التأكد عند القراءة أن نقرأ قيمة الـ W/O من الهيدر أو من خلية محددة إن كان الملف منسق دائماً بهذه الطريقة.
- لو موافق أبدأ تنفيذ (إنشاء Artisan command + Service + Import class + اختبار بسيط) وأرسلك diff للتغييرات.

تعديل: عند عدم وجود مستخدم (materialman أو foreman) سيتم إنشاء مستخدم جديد ببريد إلكتروني مُكوَّن من الاسم + `@gmail.com` وكلمة المرور `123456` مشفّرة.

كود التنفيذ (ضع هذه الملفات كما هو في المشروع):

// ملف: app/Console/Commands/ImportWorkOrders.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WorkOrderImportService;

class ImportWorkOrders extends Command
{
    protected $signature = 'import:workorders {file? : path to Excel file} {--dry-run : do not write to DB}';
    protected $description = 'Import work orders from Excel and create MRN, GatePass and Returns';

    public function handle()
    {
        $file = $this->argument('file') ?? public_path('2025 ALL SEC WORK ORDER.xlsx');
        $dryRun = $this->option('dry-run');

        $service = new WorkOrderImportService();
        $result = $service->import($file, $dryRun);

        $this->info("Import finished:");
        $this->info("WorkOrders: {$result['workorders_created']}, MRNs: {$result['mrns_created']}, GatePasses: {$result['gatepasses_created']}, Returns: {$result['returns_created']}");
        if (!empty($result['errors'])) {
            $this->error('Errors:');
            foreach ($result['errors'] as $err) {
                $this->line("- {$err}");
            }
        }
    }
}


// ملف: app/Services/WorkOrderImportService.php
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

class WorkOrderImportService
{
    public function import(string $filePath, bool $dryRun = false): array
    {
        $summary = [
            'workorders_created' => 0,
            'mrns_created' => 0,
            'gatepasses_created' => 0,
            'returns_created' => 0,
            'errors' => [],
        ];

        try {
            $sheets = Excel::toArray(null, $filePath);
            $rows = $sheets[0] ?? [];

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

            $headerIndex = null;
            $map = [];
            $headersToFind = [
                'SEC'=>'sec','MATERIAL DESCRIPTION'=>'description','RESERVATION'=>'reservation',
                'RECEIVE QTY'=>'receive_qty','QTY USE'=>'qty_use','BALANCE'=>'balance',
                'DATE RECEIVED'=>'date_received','MATERIALMAN'=>'materialman','FOREMAN NAME'=>'foreman_name',
                'DATE WITHDRAW'=>'date_withdraw'
            ];
            foreach ($rows as $i => $row) {
                $found = 0;
                foreach ($row as $j => $cell) {
                    if (!$cell) continue;
                    $cellUp = mb_strtoupper(trim($cell));
                    if (array_key_exists($cellUp, $headersToFind)) {
                        $map[$headersToFind[$cellUp]] = $j;
                        $found++;
                    }
                }
                if ($found >= 3) {
                    $headerIndex = $i;
                    break;
                }
            }

            if ($headerIndex === null) {
                $summary['errors'][] = "Header row not found in file.";
                return $summary;
            }

            for ($r = $headerIndex + 1; $r < count($rows); $r++) {
                $row = $rows[$r];
                $sec = $this->getCell($row, $map['sec'] ?? null);
                $reservation = $this->getCell($row, $map['reservation'] ?? null);
                if (empty($sec) && empty($reservation)) continue;

                $data = [
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

                try {
                    if ($dryRun) {
                        $this->simulateRow($data, $summary);
                    } else {
                        DB::transaction(function() use ($data, &$summary) {
                            $this->processRow($data, $summary);
                        });
                    }
                } catch (\Throwable $e) {
                    $msg = "Row {$r} error: " . $e->getMessage();
                    Log::error($msg);
                    $summary['errors'][] = $msg;
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

    protected function processRow(array $data, array &$summary)
    {
        $wo = WorkOrder::firstOrCreate(
            ['number' => $data['work_order_no']],
            ['foreman' => $data['foreman_name'] ?? null, 'date_withdraw' => $data['date_withdraw'] ?? null]
        );
        $summary['workorders_created'] += $wo->wasRecentlyCreated ? 1 : 0;

        $item = Item::firstOrCreate(['code' => $data['sec']], ['name' => $data['description'] ?? null]);

        // ensure users exist
        $materialmanUser = $this->ensureUserByName($data['materialman'] ?? null);
        $foremanUser = $this->ensureUserByName($data['foreman_name'] ?? null);

        $mrn = MaterialReceiptNote::firstOrCreate(
            ['reservation' => $data['reservation'], 'date' => $data['date_received']],
            ['work_order_id' => $wo->id, 'materialman' => $data['materialman'] ?? null]
        );
        $summary['mrns_created'] += $mrn->wasRecentlyCreated ? 1 : 0;

        if ($data['receive_qty'] > 0) {
            MrnItem::firstOrCreate(
                ['mrn_id' => $mrn->id, 'item_id' => $item->id],
                ['qty_received' => $data['receive_qty']]
            );
        }

        if ($data['qty_use'] > 0) {
            $gp = GatePass::create([
                'work_order_id' => $wo->id,
                'date' => $data['date_withdraw'] ?? now()->toDateString(),
                'issued_by' => $materialmanUser ? $materialmanUser->id : null,
            ]);
            GatePassItem::create([
                'gate_pass_id' => $gp->id,
                'item_id' => $item->id,
                'qty' => $data['qty_use']
            ]);
            $summary['gatepasses_created'] += 1;
        }

        if ($data['balance'] > 0) {
            MaterialReturnRequest::create([
                'work_order_id' => $wo->id,
                'item_id' => $item->id,
                'qty' => $data['balance'],
                'requested_by' => $foremanUser ? $foremanUser->id : null,
                'date' => now()->toDateString(),
            ]);
            $summary['returns_created'] += 1;
        }
    }
}


نهاية الكود.

بعد حفظ هذه التعديلات في المشروع، نفّذ الأمر التالي كـ dry-run أولاً لفحص النتائج دون كتابة في قاعدة البيانات:

php artisan import:workorders --dry-run

لو كل حاجة تمام وتأكدت من النتائج، شغّل بدون `--dry-run` لتنفيذ التغييرات فعلياً.
