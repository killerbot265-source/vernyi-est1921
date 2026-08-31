<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Order; 

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Все'),

            'new' => Tab::make('Новые')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(Order::query()->where('status', 'new')->count())
                ->badgeColor('danger'), // Красный

            'processing' => Tab::make('В работе')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))
                ->badge(Order::query()->where('status', 'processing')->count())
                ->badgeColor('warning'), // Оранжевый

            // 👇 НОВАЯ ВКЛАДКА: ОТПРАВЛЕНО
            'shipped' => Tab::make('Отправлено')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'shipped'))
                ->badge(Order::query()->where('status', 'shipped')->count())
                ->badgeColor('primary'), // Синий (стандартный цвет Filament)

            'done' => Tab::make('Архив')
                // 👇 Убрали отсюда 'shipped', оставили только финальные статусы
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['delivered', 'cancelled'])),
        ];
    }
}