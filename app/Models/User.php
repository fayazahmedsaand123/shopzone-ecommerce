<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Check if user is customer
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // Check if account is active
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Get avatar with fallback image
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D6EFD&color=fff&size=40';
    }
}