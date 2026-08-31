<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Связь: Эта позиция принадлежит заказу
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Связь: Эта позиция ссылается на конкретный товар
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}