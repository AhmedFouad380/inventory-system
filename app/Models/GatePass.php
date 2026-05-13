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
        'gp_number', 'work_order_id', 'issued_at',
        'status',
        'prepared_by', 'warehouse_keeper_id', 'engineer_id', 'notes',
        'vehicle_number_id', 'recipient_id', 'driver_id', 'destination_id',
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


    public function items(): HasMany
    {
        return $this->hasMany(GatePassItem::class);
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function vehicleNumberOption(): BelongsTo
    {
        return $this->belongsTo(\App\Models\VehicleNumber::class, 'vehicle_number_id');
    }

    public function recipientOption(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Recipient::class, 'recipient_id');
    }

    public function driverOption(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Driver::class, 'driver_id');
    }

    public function destinationOption(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Destination::class, 'destination_id');
    }
    
    public function warehouseKeeper(): BelongsTo
    {
        return $this->belongsTo(WarehouseKeeper::class, 'warehouse_keeper_id');
    }

    public function engineer(): BelongsTo
    {
    return $this->belongsTo(SiteEngineer::class, 'engineer_id');
    }
}
