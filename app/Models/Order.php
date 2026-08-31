<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Разрешаем заполнять эти поля
    protected $fillable = [
            'user_id',         // <--- ЭТО САМОЕ ВАЖНОЕ! БЕЗ НЕГО НЕ ЗАПИШЕТСЯ.
            'customer_name',
            'customer_phone',
            'city',      // Добавил
            'address',   // Добавил
            'comment',   // Добавил
            'total_price',
            'status',
            // 'category_id' - если мы добавляли его раньше, оставь, если нет - убери
        ];
    // Связь: У одного заказа много товаров
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}