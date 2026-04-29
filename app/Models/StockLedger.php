<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLedger extends Model {
    use HasCreator, HasFactory;
    const TYPE_MRN          = 'mrn';
    const TYPE_GATE_PASS    = 'gate_pass';
    const TYPE_MDR          = 'mdr';
    const TYPE_MRR          = 'mrr';
    const TYPE_TRANSFER_IN  = 'transfer_in';
    const TYPE_TRANSFER_OUT = 'transfer_out';

    protected $fillable = [
        'work_order_id', 'item_id', 'warehouse_id', 'transaction_type', 'transaction_id',
        'transaction_date', 'qty_in', 'qty_out', 'balance_after', 'created_by',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    protected $casts = [
        'transaction_date' => 'date',
        'qty_in'           => 'decimal:3',
        'qty_out'          => 'decimal:3',
        'balance_after'    => 'decimal:3',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
