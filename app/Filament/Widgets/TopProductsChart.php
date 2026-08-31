<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem; // Убедись, что у тебя есть эта модель (или используй DB::table)

class TopProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Топ-10 популярных товаров';
    
    // Сделаем график широким (на всю ширину)
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 'full';
    
    // Ставим его в самый низ (после остальных графиков)
    protected static ?int $sort = 3; 

    protected function getData(): array
    {
        $data = DB::table('order_items')
            // 👇 Исправление: Связываем таблицы order_items и products
            ->join('products', 'order_items.product_id', '=', 'products.id')
            // Берем имя из таблицы products, а количество суммируем из order_items
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Продано штук',
                    'data' => $data->pluck('total_qty'),
                    'backgroundColor' => '#3b82f6',
                    'borderRadius' => 5,
                ],
            ],
            'labels' => $data->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // 'bar' - это столбики
    }
}