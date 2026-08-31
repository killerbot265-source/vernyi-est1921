<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // Проверяем: если уже лайкнуто -> удаляем
        if ($user->favorites()->where('product_id', $id)->exists()) {
            $user->favorites()->detach($id);
            $message = 'Удалено из избранного';
        } else {
            // Если нет -> добавляем
            $user->favorites()->attach($id);
            $message = 'Добавлено в избранное';
        }

        return back(); // Возвращаем пользователя туда, где он был
    }
    
    // Страница "Моё избранное" (сделаем чуть позже)
    public function index()
    {
        $favorites = Auth::user()->favorites()->latest()->get();
        return view('favorites', compact('favorites'));
    }
}