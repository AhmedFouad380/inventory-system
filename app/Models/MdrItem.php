<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MdrItem extends Model {
    use HasFactory;
    protected $fillable = ['mdr_id', 'item_id', 'qty_disposed', 'notes'];

    protected $casts = ['qty_disposed' => 'decimal:3'];

    public function mdr(): BelongsTo
    {
        return $this->belongsTo(MaterialDisposalRequest::class, 'mdr_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
