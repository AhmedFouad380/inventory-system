<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const STATUS_OPEN      = 'open';
    const STATUS_CLOSED    = 'closed';
    const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'wo_number', 'reservation_number', 'project_id', 'site_id', 'supplier_id',
        'contract_ref', 'status', 'opened_at', 'closed_at', 'created_by', 'notes',
    ];

    protected $casts = [
        'opened_at'  => 'date',
        'closed_at'  => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materialReceiptNotes(): HasMany
    {
        return $this->hasMany(MaterialReceiptNote::class);
    }

    public function gatePasses(): HasMany
    {
        return $this->hasMany(GatePass::class);
    }

    public function materialDisposalRequests(): HasMany
    {
        return $this->hasMany(MaterialDisposalRequest::class);
    }

    public function materialReturnRequests(): HasMany
    {
        return $this->hasMany(MaterialReturnRequest::class);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(WorkOrderStock::class);
    }

    public function stockLedgers(): HasMany
    {
        return $this->hasMany(StockLedger::class);
    }

    public function transfersOut(): HasMany
    {
        return $this->hasMany(WorkOrderTransfer::class, 'from_work_order_id');
    }

    public function transfersIn(): HasMany
    {
        return $this->hasMany(WorkOrderTransfer::class, 'to_work_order_id');
    }
}
