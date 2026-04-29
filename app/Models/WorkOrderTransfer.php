<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrderTransfer extends Model {
    use HasFactory;
    const STATUS_DRAFT    = 'draft';
    const STATUS_APPROVED = 'approved';

    protected $fillable = [
        'transfer_number', 'warehouse_id', 'from_work_order_id', 'to_work_order_id',
        'transfer_date', 'status', 'approved_by', 'notes',
    ];

    protected $casts = [
        'transfer_date'   => 'date',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function fromWorkOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'from_work_order_id');
    }

    public function toWorkOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'to_work_order_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WorkOrderTransferItem::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
