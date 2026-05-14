<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
