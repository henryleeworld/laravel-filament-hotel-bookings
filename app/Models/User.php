<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'hotel' && $this->hasRole('hotels')) {
            return true;
        }

        if ($panel->getId() === 'booking' && $this->hasRole('customers')) {
            return true;
        }

        return false;
    }

    protected static function booted(): void
    {
        static::created(function (User $user) {
            if (filament()->getCurrentPanel()->getId() === 'hotel') {
                $user->assignRole('hotels');
            }
            if (filament()->getCurrentPanel()->getId() === 'booking') {
                $user->assignRole('customers');
            }
        });
    }

    /**
     * Get the hotel associated with the user.
     */
    public function hotel(): HasOne
    {
        return $this->hasOne(Hotel::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignRole(string $role): void
    {
        $this->roles()->sync(Role::where('name', $role)->first());
    }
}
