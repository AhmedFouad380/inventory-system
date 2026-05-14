<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function gatePasses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GatePass::class, 'prepared_by');
    }

    public function mrns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaterialReceiptNote::class, 'prepared_by');
    }

    public function mdrs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaterialDisposalRequest::class, 'prepared_by');
    }

    public function mrrs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaterialReturnRequest::class, 'prepared_by');
    }

    public function hasLinkedRecords(): bool
    {
        return $this->gatePasses()->exists() ||
               $this->mrns()->exists() ||
               $this->mdrs()->exists() ||
               $this->mrrs()->exists();
    }
}
