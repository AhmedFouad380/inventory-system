<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contractor extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    const TYPE_CONTRACTOR = 'contractor';
    const TYPE_COMPANY    = 'company';
    const TYPE_SUPPLIER   = 'supplier';

    protected $fillable = ['name', 'type', 'contact', 'contract_ref', 'is_active', 'created_by'];

    protected $casts = ['is_active' => 'boolean'];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }
}
