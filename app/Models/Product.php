<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'is_new',
        'is_active',
        'name',
        'slug',
        'description',
        'price',
        'image',           // Главное фото
        'specifications',  // Характеристики (JSON)
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'specifications' => 'array',
    ];

    // === СВЯЗИ ===

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 1. Связь с Галереей
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // 2. Связь со Складом/Вариантами
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    // Остальные связи (Заказы, Избранное)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function usersWhoLiked()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function isFavorited()
    {
        if (!auth()->check()) return false;
        return $this->usersWhoLiked()->where('user_id', auth()->id())->exists();
    }
}