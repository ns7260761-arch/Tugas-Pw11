<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== Relasi =====
    public function posts(): HasMany     { return $this->hasMany(Post::class); }
    public function orders(): HasMany    { return $this->hasMany(Order::class); }
    public function addresses(): HasMany { return $this->hasMany(Address::class); }
    public function reviews(): HasMany   { return $this->hasMany(Review::class); }

    // ===== Pengecekan role =====
    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isEditor(): bool { return $this->role === 'editor'; }
}
