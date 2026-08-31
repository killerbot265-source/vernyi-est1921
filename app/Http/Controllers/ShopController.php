<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // === 1. ЛОГИКА КАТЕГОРИЙ ===
        $selectedSlugs = [];

        // Собираем категории из фильтра (?categories[]=...)
        if ($request->has('categories')) {
            $cats = $request->get('categories');
            if (is_array($cats)) {
                $selectedSlugs = array_merge($selectedSlugs, $cats);
            } else {
                $selectedSlugs[] = $cats;
            }
        }

        // Собираем категорию из ссылки с Главной (?category=...)
        if ($request->has('category')) {
            $selectedSlugs[] = $request->get('category');
        }

        $selectedSlugs = array_unique($selectedSlugs);

        // Если что-то выбрали — фильтруем
        if (!empty($selectedSlugs)) {
            $catIds = Category::whereIn('slug', $selectedSlugs)->pluck('id');
            
            if ($catIds->isNotEmpty()) {
                $query->whereIn('category_id', $catIds);
            }

            // Ставим галочки в фильтре
            $request->merge(['categories' => $selectedSlugs]);
        }

        // === 2. Фильтр по Цене ===
        if ($min = $request->get('min_price')) {
            $query->where('price', '>=', $min);
        }
        if ($max = $request->get('max_price')) {
            $query->where('price', '<=', $max);
        }

        // === 3. ПОИСК ===
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // === 4. Сортировка (ИЗМЕНЕНО) ===
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            
            case 'newest': // Явно для "Сначала новые"
            default:       // И по умолчанию
                $query->orderBy('is_new', 'desc')     // 1. Сначала товары с галочкой NEW
                      ->orderBy('created_at', 'desc'); // 2. Потом просто свежие по дате
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }
}