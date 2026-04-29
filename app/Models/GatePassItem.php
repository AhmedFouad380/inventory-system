<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatePassItem extends Model {
    use HasFactory;
    protected $fillable = ['gate_pass_id', 'item_id', 'qty_issued', 'reel_number', 'notes'];

    protected $casts = ['qty_issued' => 'decimal:3'];

    public function gatePass(): BelongsTo
    {
        return $this->belongsTo(GatePass::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
