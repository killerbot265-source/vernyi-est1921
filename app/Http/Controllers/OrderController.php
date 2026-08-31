<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Показать детали конкретного заказа
    public function show($id)
    {
        // Ищем заказ по ID
        // Важно: используем where('user_id', Auth::id()), чтобы никто не мог подсмотреть чужой заказ!
        $order = Order::with('items.product') // Подгружаем товары внутри заказа
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('order-details', compact('order'));
    }
}