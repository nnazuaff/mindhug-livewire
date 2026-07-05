<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'full_name',
    'username',
    'email',
    'phone',
    'role',
    'avatar',
    'trial_started_at',
    'is_trial_active',
    'birth_date',
    'password',
    'last_login_at',
])]

#[Hidden(['password'])]
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
            'trial_started_at' => 'datetime',
            'is_trial_active' => 'boolean',
            'birth_date' => 'date',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    // Helper
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->full_name).'&background=a47551&color=fff&size=200';
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
