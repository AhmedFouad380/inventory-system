<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialReturnRequest extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const STATUS_DRAFT     = 'draft';
    const STATUS_CONFIRMED = 'confirmed';

    protected $fillable = [
        'mrr_number', 'work_order_id', 'warehouse_id', 'supplier_id', 'mrr_date', 'return_to',
        'transport_details', 'receiver_signature', 'status', 'prepared_by', 'notes',
    ];

    protected $casts = ['mrr_date' => 'date'];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MrrItem::class, 'mrr_id');
    }
}
