<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductVariant;

class CartController extends Controller
{
    // 1. Показать корзину
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    // 2. Добавить товар (С УЧЕТОМ ВАРИАНТОВ)
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Получаем цвет и размер из запроса
        $color = $request->input('color');
        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);

        // 👇 ГЛАВНОЕ ИЗМЕНЕНИЕ: Генерируем уникальный ключ
        // Если цвет/размер не выбраны, ключ будет просто ID (5___)
        // Если выбраны, будет: 5_Черный_XL
        $cartKey = $id . '_' . $color . '_' . $size;

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id, // Сохраняем реальный ID отдельно
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image,
                "color" => $color, // Запоминаем цвет
                "size" => $size    // Запоминаем размер
            ];
        }

        session()->put('cart', $cart);

        // Ответ для AJAX (чтобы обновить кружок в шапке)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    // 3. Обновить количество
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $key = $request->id; // Это наш сложный ключ (5_Черный_XL)

            if(isset($cart[$key])) {
                // Если кол-во > 0, обновляем
                if ($request->quantity > 0) {
                    $cart[$key]["quantity"] = $request->quantity;
                    session()->put('cart', $cart);
                } else {
                    // Если 0, удаляем
                    unset($cart[$key]);
                    session()->put('cart', $cart);
                }

                // Пересчитываем итоги для JS
                $total = 0;
                foreach($cart as $item) $total += $item['price'] * $item['quantity'];
                
                // Считаем итог конкретной строки (если товар не удален)
                $itemTotal = isset($cart[$key]) ? $cart[$key]['price'] * $cart[$key]['quantity'] : 0;

                return response()->json([
                    'success' => true,
                    'item_total' => number_format($itemTotal, 0, ' ', ' ') . ' ₸',
                    'cart_total' => number_format($total, 0, ' ', ' ') . ' ₸',
                    'cart_count' => count($cart)
                ]);
            }
        }
    }

    // 4. Удалить товар
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            // Пересчет итогов
            $total = 0;
            foreach($cart as $item) $total += $item['price'] * $item['quantity'];

            return response()->json([
                'success' => true,
                'cart_total' => number_format($total, 0, ' ', ' ') . ' ₸',
                'cart_count' => count($cart)
            ]);
        }
    }

    // 5. Оформить заказ
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) return redirect()->back()->with('error', 'Корзина пуста!');

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        // 1. Считаем сумму ТОЛЬКО товаров
        $itemsTotal = 0;
        foreach($cart as $item) {
            $itemsTotal += $item['price'] * $item['quantity'];
        }

        // 2. Логика доставки
        // Если сумма товаров >= 30 000, то доставка 0, иначе 2500
        $shippingCost = ($itemsTotal >= 30000) ? 0 : 2500;

        // 3. Итоговая сумма (Товары + Доставка)
        $grandTotal = $itemsTotal + $shippingCost;

        // 4. Создаем заказ с ОБЩЕЙ суммой
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'comment' => $request->comment,
            'total_price' => $grandTotal, // Записываем сумму вместе с доставкой
            'status' => 'new'
        ]);

        // 2. Проходимся по товарам в корзине
        foreach($cart as $key => $item) {
            // Сохраняем товар в историю заказа
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // 👇👇👇 НАЧАЛО: АВТОМАТИЗАЦИЯ СКЛАДА 👇👇👇
            
            // Если у товара есть цвет и размер (значит это Вариант)
            if(isset($item['color']) && isset($item['size'])) {
                
                // Ищем конкретный вариант в базе (Серый + XL)
                $variant = ProductVariant::where('product_id', $item['product_id'])
                    ->where('color', $item['color'])
                    ->where('size', $item['size'])
                    ->first();

                // Если нашли - уменьшаем кол-во
                if ($variant) {
                    // decrement('stock', 2) означает: stock = stock - 2
                    $variant->decrement('stock', $item['quantity']);
                }
            }
            // 👆👆👆 КОНЕЦ: АВТОМАТИЗАЦИЯ СКЛАДА 👆👆👆
        }

        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Заказ принят! Мы скоро свяжемся с вами.');
    }
}