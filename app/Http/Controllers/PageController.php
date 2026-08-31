<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 👇 ОБЯЗАТЕЛЬНО ДОБАВЬ ЭТУ СТРОКУ
use App\Models\Product; 

class PageController extends Controller
{
    public function delivery()
    {
        return view('pages.delivery');
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function sizeGuide()
    {
        return view('pages.size-guide');
    }

    public function contacts()
    {
        return view('pages.contacts');
    }

    public function home()
    {
        // Берем товары, у которых включена галочка "is_new"
        $newArrivals = Product::where('is_active', true)
            ->where('is_new', true)
            ->latest()
            ->take(8)
            ->get();

        // Если новинок с галочкой нет, берем просто последние 4
        if ($newArrivals->isEmpty()) {
            $newArrivals = Product::where('is_active', true)->latest()->take(4)->get();
        }

        return view('welcome', compact('newArrivals'));
    }

    public function about()
    {
        // Эта строка пытается открыть файл вида resources/views/about.blade.php
        // Если у тебя файл называется иначе (например, about_us), поменяй название тут.
        return view('about'); 
    }
}