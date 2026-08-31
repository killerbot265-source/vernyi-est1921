<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; 
    protected static ?string $navigationLabel = 'Пользователи';
    protected static ?string $modelLabel = 'Пользователь';
    protected static ?string $pluralModelLabel = 'Пользователи';
    protected static ?int $navigationSort = 10; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Данные аккаунта')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Имя')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        // Поле пароля
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Пароль')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        // Тумблер в форме (тоже защищаем от самого себя)
                        Forms\Components\Toggle::make('is_admin')
                            ->label('Права Администратора')
                            ->helperText('Включи, чтобы дать доступ к панели управления')
                            ->onColor('success')
                            ->offColor('danger')
                            // Не даем отключить права самому себе даже при редактировании
                            ->disabled(fn (?User $record) => $record?->id === auth()->id()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                // 1. ВИЗУАЛЬНЫЙ СТАТУС (Просто иконка, нажать нельзя)
                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Статус')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check') // Щит
                    ->falseIcon('heroicon-o-user')        // Человек
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y H:i')
                    ->label('Регистрация')
                    ->sortable(),
            ])
            ->actions([
                // 2. БЕЗОПАСНАЯ КНОПКА ПРАВ (С подтверждением)
                Tables\Actions\Action::make('toggleAdmin')
                    ->label(fn (User $record) => $record->is_admin ? 'Снять права' : 'Дать права')
                    ->icon(fn (User $record) => $record->is_admin ? 'heroicon-o-lock-open' : 'heroicon-o-lock-closed')
                    ->color(fn (User $record) => $record->is_admin ? 'danger' : 'success')
                    ->requiresConfirmation() // 👈 Всплывающее окно
                    ->modalHeading('Изменение прав доступа')
                    ->modalDescription(fn (User $record) => $record->is_admin 
                        ? 'Вы уверены? Пользователь потеряет доступ к админке.' 
                        : 'Вы уверены? Пользователь получит полный доступ к управлению магазином.')
                    ->action(function (User $record) {
                        $record->update(['is_admin' => !$record->is_admin]);
                    })
                    // СКРЫВАЕМ для себя (чтобы случайно не заблокироваться)
                    ->hidden(fn (User $record) => $record->id === auth()->id()),

                Tables\Actions\EditAction::make(),

                // 3. БЕЗОПАСНОЕ УДАЛЕНИЕ
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    // СКРЫВАЕМ для себя (чтобы случайно не удалиться)
                    ->hidden(fn (User $record) => $record->id === auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        // Не даем удалить себя даже через массовое удаление
                        ->action(function (Tables\Actions\DeleteBulkAction $action, \Illuminate\Database\Eloquent\Collection $records) {
                            // Фильтруем записи, удаляем всех КРОМЕ себя
                            $records->reject(fn ($user) => $user->id === auth()->id())
                                    ->each->delete();
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}