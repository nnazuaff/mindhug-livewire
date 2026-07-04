<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'username',
        'email',
        'full_name',
        'password',
        'role',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isDev(): bool
    {
        return $this->role === 'dev';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canManageOrders(): bool
    {
        return in_array($this->role, ['dev', 'admin']);
    }
}
