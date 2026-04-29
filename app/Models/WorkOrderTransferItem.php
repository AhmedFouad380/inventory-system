<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderTransferItem extends Model
{
    use HasFactory;

    protected $fillable = ['work_order_transfer_id', 'item_id', 'qty_transferred', 'notes'];

    protected $casts = [
        'qty_transferred' => 'decimal:3',
    ];

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(WorkOrderTransfer::class, 'work_order_transfer_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
