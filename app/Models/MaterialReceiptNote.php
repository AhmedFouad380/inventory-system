<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialReceiptNote extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const STATUS_DRAFT     = 'draft';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_APPROVED  = 'approved';

    protected $fillable = [
        'mrn_number', 'work_order_id', 'warehouse_id', 'supplier_id', 'mrn_date',
        'delivery_note_ref', 'vehicle_number', 'contract_ref', 'status',
        'prepared_by', 'warehouse_keeper_id', 'approved_by', 'approved_at', 'notes',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    protected $casts = [
        'mrn_date'    => 'date',
        'approved_at' => 'datetime',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function warehouseKeeper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warehouse_keeper_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MrnItem::class, 'mrn_id');
    }
}
