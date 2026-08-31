<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // 1. Ищем категорию по слагу (например, 't-shirts')
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // 2. Берем товары этой категории
        $products = $category->products()->where('is_active', true)->get();

        // 3. Открываем страницу 'category' и передаем туда данные
        return view('category', compact('category', 'products'));
    }
}