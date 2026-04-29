<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    protected $fillable = ['item_code', 'name', 'description', 'unit', 'category_id', 'is_active', 'created_by'];

    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function mrnItems(): HasMany
    {
        return $this->hasMany(MrnItem::class);
    }

    public function gatePassItems(): HasMany
    {
        return $this->hasMany(GatePassItem::class);
    }

    public function mdrItems(): HasMany
    {
        return $this->hasMany(MdrItem::class);
    }

    public function mrrItems(): HasMany
    {
        return $this->hasMany(MrrItem::class);
    }

    public function stockLedgers(): HasMany
    {
        return $this->hasMany(StockLedger::class);
    }
}
