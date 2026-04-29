<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialDisposalRequest extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const REASON_DAMAGED = 'damaged';
    const REASON_SCRAP   = 'scrap';
    const REASON_EXPIRED = 'expired';
    const REASON_EXCESS  = 'excess';

    const STATUS_DRAFT            = 'draft';
    const STATUS_PENDING_APPROVAL = 'pending_approval';
    const STATUS_APPROVED         = 'approved';
    const STATUS_EXECUTED         = 'executed';

    protected $fillable = [
        'mdr_number', 'work_order_id', 'mdr_date', 'disposal_reason',
        'disposal_method', 'status', 'prepared_by', 'approved_by',
        'approved_at', 'inspection_notes', 'notes',
    ];

    protected $casts = [
        'mdr_date'    => 'date',
        'approved_at' => 'datetime',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MdrItem::class, 'mdr_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
