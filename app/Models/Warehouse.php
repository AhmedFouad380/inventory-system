<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'location', 'is_active'];

    public function mrns(): HasMany
    {
        return $this->hasMany(MaterialReceiptNote::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(WorkOrderStock::class);
    }
}
