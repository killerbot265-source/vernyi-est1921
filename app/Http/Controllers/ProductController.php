<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        // 👇 ГЛАВНОЕ: Добавили 'variants' в загрузку
        $product = Product::with(['category', 'images', 'variants'])
            ->where('is_active', true)
            ->findOrFail($id);

        // Похожие товары (оставляем твою логику)
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('product', compact('product', 'similarProducts'));
    }
}