<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';
    protected static ?string $pluralModelLabel = 'Заказы';

    // 👇 1. НАСТРОЙКИ ГЛОБАЛЬНОГО ПОИСКА (НОВОЕ!)
    // В результатах поиска будет показываться ID заказа
    protected static ?string $recordTitleAttribute = 'id';

    // 👇 2. ПО КАКИМ ПОЛЯМ ИСКАТЬ
    // Filament будет искать совпадения в Имени, Телефоне и ID
    public static function getGloballySearchableAttributes(): array
    {
        return ['customer_name', 'customer_phone', 'id'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === СЕКЦИЯ 1: ИНФОРМАЦИЯ О КЛИЕНТЕ ===
                Section::make('Информация о заказе')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Имя клиента')
                            ->required(),
                        
                        TextInput::make('customer_phone')
                            ->label('Телефон')
                            ->required(),

                        Select::make('status')
                            ->label('Статус заказа')
                            ->options([
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'shipped' => 'Отправлен',
                                'delivered' => 'Доставлен',
                                'cancelled' => 'Отменен',
                            ])
                            ->required()
                            ->default('new'),

                        TextInput::make('total_price')
                            ->label('Общая сумма (₸)')
                            ->numeric()
                            ->readOnly(),
                    ])->columns(2),

                // === СЕКЦИЯ 2: ДАННЫЕ ДОСТАВКИ ===
                Section::make('Данные доставки')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        TextInput::make('city')
                            ->label('Город')
                            ->placeholder('Алматы')
                            ->columnSpan(1),

                        TextInput::make('address')
                            ->label('Адрес')
                            ->placeholder('Улица, дом, квартира')
                            ->columnSpan(2),

                        Textarea::make('comment')
                            ->label('Комментарий клиента')
                            ->placeholder('Код домофона, этаж...')
                            ->columnSpanFull(),
                    ])->columns(3),

                // === СЕКЦИЯ 3: ТОВАРЫ ===
                Section::make('Товары в заказе')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label('Товар')
                                    ->disabled(),
                                
                                TextInput::make('quantity')
                                    ->label('Кол-во')
                                    ->numeric()
                                    ->disabled(),

                                TextInput::make('price')
                                    ->label('Цена за шт.')
                                    ->numeric()
                                    ->disabled(),
                            ])
                            ->columns(3)
                            ->addable(false)
                            ->deletable(false)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->select('orders.*');
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(), // Добавил searchable сюда тоже
                
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Клиент')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Телефон')
                    ->searchable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('Город')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Сумма')
                    ->money('kzt')
                    ->sortable(),

                // Выпадающий список для быстрой смены статуса
                Tables\Columns\SelectColumn::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новый',
                        'processing' => 'В обработке',
                        'shipped' => 'Отправлен',
                        'delivered' => 'Доставлен',
                        'cancelled' => 'Отменен',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y H:i')
                    ->label('Дата заказа')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Кнопка WhatsApp
                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Order $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->customer_phone);
                        $text = "Здравствуйте, {$record->customer_name}! Пишу из магазина Vernyi по поводу заказа №{$record->id}.";
                        return "https://wa.me/{$phone}?text=" . urlencode($text);
                    })
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('print')
                    ->label('Печать')
                    ->icon('heroicon-o-printer') // Иконка принтера
                    ->color('gray') // Нейтральный цвет
                    ->url(fn (Order $record) => route('orders.print', $record))
                    ->openUrlInNewTab(), // Открывать в новой вкладке
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}