<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model {
    use HasFactory;
    protected $fillable = ['name', 'contact', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function materialReceiptNotes(): HasMany
    {
        return $this->hasMany(MaterialReceiptNote::class);
    }
}
