<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MrrItem extends Model {
    use HasFactory;
    protected $fillable = ['mrr_id', 'item_id', 'qty_returned', 'return_reason'];

    protected $casts = ['qty_returned' => 'decimal:3'];

    public function mrr(): BelongsTo
    {
        return $this->belongsTo(MaterialReturnRequest::class, 'mrr_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
