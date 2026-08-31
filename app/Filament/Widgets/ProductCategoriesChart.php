<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'Товары по категориям';
    
    // Сортировка: чем меньше число, тем выше виджет на странице
    protected static ?int $sort = 2; 
    protected int | string | array $columnSpan = 1; // 1 = Занимает половину места (1 колонку)

    protected function getData(): array
    {
        // Берем все категории и считаем, сколько в них продуктов
        $data = Category::withCount('products')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Товары',
                    'data' => $data->pluck('products_count'), // Числа (количество)
                    'backgroundColor' => [
                        '#f59e0b', // Amber (Желтый)
                        '#10b981', // Emerald (Зеленый)
                        '#3b82f6', // Blue (Синий)
                        '#ef4444', // Red (Красный)
                        '#8b5cf6', // Violet (Фиолетовый)
                    ], 
                ],
            ],
            'labels' => $data->pluck('name'), // Названия категорий
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Можно поменять на 'pie' (полный круг)
    }
}