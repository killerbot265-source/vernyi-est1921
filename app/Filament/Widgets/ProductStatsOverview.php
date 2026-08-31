<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStatsOverview extends BaseWidget
{
    // Сортировка: ставим 1, чтобы (возможно) она встала перед или рядом с диаграммой
    protected static ?int $sort = 1; // 1 = Самый верх
    protected int | string | array $columnSpan = 'full'; // 'full' = Во всю ширину экрана
    
    protected function getStats(): array
    {
        return [
            // Карточка 1: Всего товаров
            Stat::make('Всего товаров', Product::count())
                ->description('Общее количество SKU')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary') // Синий цвет
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Декоративный график

            // Карточка 2: Средняя цена
            Stat::make('Средняя цена', number_format(Product::avg('price'), 0, '.', ' ') . ' ₸')
                ->description('Средний чек товара')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'), // Зеленый цвет

            // Карточка 3: Новинки за месяц
            Stat::make('Новинки (30 дней)', Product::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Добавлено недавно')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'), // Желтый цвет
        ];
    }
}