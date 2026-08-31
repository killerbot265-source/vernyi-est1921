<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductsTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Новые товары';
    
    // Тоже второй ряд (встанет рядом с кругом)
    protected static ?int $sort = 2; 
    
    // Занимает 1 место
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Считаем сколько товаров создано по месяцам
        $data = Trend::model(Product::class)
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Новые товары',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Синяя линия
                    'fill' => true,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
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