<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // <-- Поле админа
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'is_admin' => 'boolean',
        ];
    }

    // 👇 БЕЗОПАСНОСТЬ: Пускаем в админку только если is_admin = true
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    // 👇 ВОТ ЭТО Я ЗАБЫЛ ВЕРНУТЬ: Связь с заказами
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Связь с избранными товарами
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
}