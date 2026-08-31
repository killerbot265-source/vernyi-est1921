<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Динамика заказов (30 дней)';
    protected static ?int $sort = 3; // Позиция на экране (после карточек)
    protected int | string | array $columnSpan = 'full'; // На всю ширину

    protected function getData(): array
    {
        // Получаем данные за последний месяц
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Количество заказов',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Синий цвет линии
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)', // Прозрачная заливка
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Линейный график
    }
}