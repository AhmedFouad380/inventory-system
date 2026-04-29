<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model {
    use HasFactory;
    use SoftDeletes, HasCreator;

    protected $fillable = ['name', 'description', 'is_active', 'created_by'];

    protected $casts = ['is_active' => 'boolean'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
