<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    // Обновляем данные раз в 60 секунд (чуть реже, чтобы не грузить базу)
    protected static ?string $pollingInterval = '60s';

    // Сортировка 1 (Самый верх)
    protected static ?int $sort = 1;
    
    // Растягиваем блок на всю ширину
    protected int | string | array $columnSpan = 'full';

    // 4 колонки, чтобы было 2 идеальных ряда
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        // === 1. Расчеты денег ===
        
        $revenueToday = Order::where('status', 'delivered')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        $revenueMonth = Order::where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        $revenueTotal = Order::where('status', 'delivered')->sum('total_price');

        // Расчет среднего чека
        $avgCheck = Order::where('status', 'delivered')->exists() 
            ? Order::where('status', 'delivered')->avg('total_price') 
            : 0;

        // График для общей выручки
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $chartData[] = Order::whereDate('created_at', now()->subDays($i))
                ->where('status', 'delivered')
                ->sum('total_price');
        }

        return [
            // === РЯД 1 (Финансы) ===
            
            Stat::make('Выручка (Сегодня)', number_format($revenueToday, 0, ' ', ' ') . ' ₸')
                ->description('За 24 часа')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Выручка (Месяц)', number_format($revenueMonth, 0, ' ', ' ') . ' ₸')
                ->description('Текущий месяц')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('Общая выручка', number_format($revenueTotal, 0, ' ', ' ') . ' ₸')
                ->description('Все время')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart($chartData),

            Stat::make('Средний чек', number_format($avgCheck, 0, ' ', ' ') . ' ₸')
                ->description('Средняя стоимость заказа')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('primary'),

            // === РЯД 2 (Операционка) ===

            Stat::make('Новые заказы', Order::where('status', 'new')->count())
                ->description('Требуют внимания')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('danger'),

            Stat::make('Товары', Product::where('is_active', true)->count())
                ->description('Активные позиции')
                ->color('success') // Сделал зеленым, так позитивнее
                ->descriptionIcon('heroicon-m-cube'),

            Stat::make('Всего заказов', Order::count())
                ->description('История продаж')
                ->color('gray')
                ->descriptionIcon('heroicon-m-shopping-bag'),

            // 👇 8-я КАРТОЧКА: Отмененные заказы
            Stat::make('Отмены', Order::where('status', 'cancelled')->count())
                ->description('Несостоявшиеся')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}