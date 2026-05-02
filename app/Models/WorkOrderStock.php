<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderStock extends Model {
    use HasFactory;
    protected $fillable = [
        'work_order_id', 'item_id', 'warehouse_id',
        'qty_received', 'qty_issued', 'qty_disposed',
        'qty_returned', 'qty_transfer_out', 'qty_transfer_in', 'balance',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    protected $casts = [
        'qty_received'     => 'decimal:3',
        'qty_issued'       => 'decimal:3',
        'qty_disposed'     => 'decimal:3',
        'qty_returned'     => 'decimal:3',
        'qty_transfer_out' => 'decimal:3',
        'qty_transfer_in'  => 'decimal:3',
        'balance'          => 'decimal:3',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * إعادة حساب الرصيد وفق المعادلة الكاملة
     */
    public function recalculateBalance(): void
    {
        $this->balance = $this->qty_received
            + $this->qty_transfer_in
            + $this->qty_returned
            - $this->qty_issued
            - $this->qty_disposed
            - $this->qty_transfer_out;

        $this->save();
    }
}
