<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatePass extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const STATUS_DRAFT     = 'draft';
    const STATUS_ISSUED    = 'issued';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_APPROVED  = 'approved';

    protected $fillable = [
        'gp_number', 'work_order_id', 'issued_at', 'vehicle_number',
        'recipient_name', 'driver_name', 'destination', 'status',
        'prepared_by', 'warehouse_keeper_id', 'engineer_id', 'notes',
    ];

    protected $casts = ['issued_at' => 'datetime'];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function warehouseKeeper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'warehouse_keeper_id');
    }

    public function engineer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GatePassItem::class);
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
    
}
