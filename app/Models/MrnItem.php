<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MrnItem extends Model {
    use HasFactory;
    protected $fillable = ['mrn_id', 'item_id', 'qty_received', 'reel_number', 'notes'];

    protected $casts = ['qty_received' => 'decimal:3'];

    public function mrn(): BelongsTo
    {
        return $this->belongsTo(MaterialReceiptNote::class, 'mrn_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
