<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Товары';
    protected static ?string $modelLabel = 'Товар';
    protected static ?string $pluralModelLabel = 'Товары';
    protected static ?string $recordTitleAttribute = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === ВЕРХНИЙ БЛОК ===
                Grid::make(3)->schema([
                    // Левая колонка
                    Section::make('Основная информация')->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->label('Категория')
                            ->searchable()
                            ->preload(),
                        
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Название товара')
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if (filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->label('URL (Slug)')
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->dehydrated(),
                        
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₸')
                            ->label('Цена'),

                        // 👇 ГЕНЕРАТОР ОПИСАНИЯ (СТИЛЬ: ОПИСАТЕЛЬНЫЙ, НЕ РЕКЛАМНЫЙ)
                        RichEditor::make('description')
                            ->label('Полное описание')
                            ->columnSpanFull()
                            ->hintAction(
                                Action::make('generateDescription')
                                    ->icon('heroicon-o-sparkles')
                                    ->label('Сгенерировать AI')
                                    ->color('warning')
                                    ->action(function ($get, $set) {
                                        $name = $get('name'); 
                                        if (!$name) {
                                            Notification::make()->title('Сначала введите название!')->warning()->send();
                                            return;
                                        }
                                        Notification::make()->title('Gemini описывает товар... 🧠')->info()->send();

                                        $apiKey = env('GEMINI_API_KEY');
                                        $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
                                        //$baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
                                        $url = $baseUrl . '?key=' . $apiKey;

                                        // 👇 НОВЫЙ ПРОМПТ: ФОКУС НА ТОВАРЕ, А НЕ НА ПОКУПАТЕЛЕ
                                        $prompt = "Ты — старший fashion-копирайтер премиального бренда одежды. Напиши описание для товара '{$name}'.
                                                   Объем: Строго 3-4 предложений. Один абзац.
                                                   Стиль: Фактический, описательный, премиальный (эстетика 'тихой роскоши'). Текст должен продавать за счет описания качества, а не эмоций.
                                                   О чем писать: Опиши плотность и фактуру материала, особенности кроя (fit), качество швов, фурнитуру и тактильные ощущения.
                                                   ЗАПРЕЩЕНО: Не используй рекламные призывы ('Купи', 'Почувствуй', 'Забудь'). Никакой воды, описывай только физические свойства изделия.
                                                   Формат: HTML (используй теги <p> и <strong>). Без списков.";

                                        try {
                                            $response = Http::withoutVerifying()->post($url, [
                                                'contents' => [['parts' => [['text' => $prompt]]]]
                                            ]);
                                            $json = $response->json();
                                            
                                            if (isset($json['error'])) {
                                                Notification::make()->title('Ошибка API: ' . $json['error']['message'])->danger()->send();
                                                return;
                                            }

                                            $aiText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;

                                            if ($aiText) {
                                                $cleanText = str_replace(['```html', '```'], '', $aiText);
                                                $safeHtml = strip_tags($cleanText, '<p><strong><b><i><em><br>');
                                                $set('description', $safeHtml);
                                                Notification::make()->title('Готово! ✨')->success()->send();
                                            } else {
                                                Notification::make()->title('Пустой ответ от Google')->warning()->send();
                                            }
                                        } catch (\Exception $e) {
                                            Notification::make()->title('Ошибка: ' . $e->getMessage())->danger()->send();
                                        }
                                    })
                            ),

                    ])->columnSpan(2),

                    // Правая колонка
                    Grid::make(1)->schema([
                        Section::make('Статус и Фото')->schema([
                            Toggle::make('is_active')
                                ->required()
                                ->default(true)
                                ->label('Активен'),
                            
                            Toggle::make('is_new')
                                ->label('Метка "NEW"')
                                ->default(false)
                                ->onColor('success')
                                ->offColor('gray'),

                            FileUpload::make('image')
                                ->image()
                                ->directory('products')
                                ->label('Главное изображение')
                                ->imageEditor(),
                        ]),
                    ])->columnSpan(1),
                ]),

                Section::make('Склад и Варианты')
                    ->schema([
                        Repeater::make('variants')
                            ->relationship()
                            ->schema([
                                TextInput::make('color')
                                    ->hiddenLabel()
                                    ->placeholder('Цвет')
                                    ->required()
                                    ->columnSpan(5),

                                Select::make('size')
                                    ->hiddenLabel()
                                    ->placeholder('Размер')
                                    ->options([
                                        'XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL',
                                        '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40',
                                        '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45',
                                    ])
                                    ->required()
                                    ->columnSpan(4),

                                TextInput::make('stock')
                                    ->hiddenLabel()
                                    ->placeholder('Кол-во')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->columnSpan(3),
                            ])
                            ->columns(12)
                            ->defaultItems(1)
                            ->addActionLabel('Добавить вариант')
                            ->cloneable()
                            ->reorderableWithButtons(),
                ]),

                // === НИЖНИЙ БЛОК: Характеристики и Галерея ===
                Section::make('Дополнительно')->schema([
                    
                    // ГЕНЕРАТОР ХАРАКТЕРИСТИК
                    KeyValue::make('specifications')
                        ->label('Характеристики (Бренд, Материал и т.д.)')
                        ->keyLabel('Параметр')
                        ->valueLabel('Значение')
                        ->hintAction(
                            Action::make('generateSpecs')
                                ->icon('heroicon-o-sparkles')
                                ->label('AI Характеристики')
                                ->color('info')
                                ->action(function ($get, $set) {
                                    $name = $get('name');   
                                    $desc = strip_tags($get('description') ?? '');
                                    if (!$name) {
                                        Notification::make()->title('Введите название товара!')->warning()->send();
                                        return;
                                    }
                                    Notification::make()->title('Подбираю характеристики... ⚙️')->info()->send();

                                    $apiKey = env('GEMINI_API_KEY');
                                    $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
                                    //$baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
                                    $url = $baseUrl . '?key=' . $apiKey;

                                    $prompt = "ТТы — fashion-технолог. Твоя задача: на основе названия и описания товара создать JSON-объект со спецификацией.
                                               Товар: '{$name}'.
                                               описания: '{$desc}'.
                                               
                                               Задача: Создай JSON объект.
                                               ВАЖНО: - Верни ИСКЛЮЧИТЕЛЬНО чистый JSON. Никаких блоков ```json, никаких приветствий.
                                                      - Все значения (values) должны быть строками (String) на русском языке. Массивы запрещены.
                                                      - Если точной информации нет, сделай экспертный вывод исходя из типа ткани, либо напиши 'Не указано'.
                                               ОЖИДАЕМЫЕ КЛЮЧИ: \"Бренд\" (Бренд)
                                                                \"Состав материала\" (Состав материала)
                                                                \"Сезонность\" (Сезонность: Лето, Зима, Демисезон, Мультисезон)
                                                                \"Фасон/Крой\" (Фасон/Крой)
                                                                \"details\" (Детали через запятую)
                                                                \"Плотность ткани\" (Плотность ткани, например: Средняя, Высокая, Флис 320 гр/м2)
                                                                \"Инструкция по уходу\" (Инструкция по уходу)
                                                                \"Страна производства\" (Страна производства)";

                                    try {
                                        $response = Http::withoutVerifying()->post($url, [
                                            'contents' => [['parts' => [['text' => $prompt]]]]
                                        ]);
                                        $json = $response->json();
                                        
                                        if (isset($json['error'])) {
                                            Notification::make()->title('Ошибка API: ' . $json['error']['message'])->danger()->send();
                                            return;
                                        }

                                        $aiText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;

                                        if ($aiText) {
                                            $cleanJson = str_replace(['```json', '```'], '', $aiText);
                                            $specs = json_decode($cleanJson, true);

                                            if (is_array($specs)) {
                                                $set('specifications', $specs);
                                                Notification::make()->title('Характеристики готовы! 📋')->success()->send();
                                            } else {
                                                Notification::make()->title('Ошибка формата данных')->warning()->send();
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        Notification::make()->title('Ошибка сети')->danger()->send();
                                    }
                                })
                        ),

                    Repeater::make('images')
                        ->relationship()
                        ->schema([
                            FileUpload::make('image_path')
                                ->image()
                                ->directory('products_gallery')
                                ->required()
                        ])
                        ->grid(4)
                        ->label('Галерея дополнительных фото')
                        ->addActionLabel('Загрузить фото'),
                ]),

                // 👇 БЛОК SEO ОПТИМИЗАЦИИ
                Section::make('SEO Оптимизация (Google / Yandex)')
                    ->collapsed() 
                    ->description('Мета-теги для поисковиков.')
                    ->headerActions([
                        Action::make('generateSEO')
                            ->label('✨ Сгенерировать SEO')
                            ->color('success')
                            ->action(function ($get, $set) {
                                $name = $get('name');
                                $descRaw = strip_tags($get('description') ?? '');
                                
                                if (!$name) {
                                    Notification::make()->title('Сначала заполните название!')->warning()->send();
                                    return;
                                }

                                Notification::make()->title('Анализирую... 🔎')->info()->send();

                                $apiKey = env('GEMINI_API_KEY');
                                $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
                                //$baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
                                $url = $baseUrl . '?key=' . $apiKey;

                                $prompt = "Ты SEO-специалист. Создай Meta Title и Meta Description для товара: '{$name}'.
                                           Описание: '{$descRaw}'.
                                           Требования:
                                           1. Title: до 60 символов, цепляющий.
                                           2. Description: до 160 символов, продающий.
                                           Формат ответа: Только чистый JSON объект: {\"title\": \"...\", \"description\": \"...\"}.
                                           БЕЗ Markdown.";

                                try {
                                    $response = Http::withoutVerifying()->post($url, [
                                        'contents' => [['parts' => [['text' => $prompt]]]]
                                    ]);
                                    $json = $response->json();
                                    $aiText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;

                                    if ($aiText) {
                                        $cleanJson = str_replace(['```json', '```'], '', $aiText);
                                        $seoData = json_decode($cleanJson, true);

                                        if (is_array($seoData)) {
                                            $set('seo_title', $seoData['title'] ?? '');
                                            $set('seo_description', $seoData['description'] ?? '');
                                            Notification::make()->title('SEO готово! 🚀')->success()->send();
                                        }
                                    }
                                } catch (\Exception $e) {
                                    Notification::make()->title('Ошибка')->danger()->send();
                                }
                            })
                    ])
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Meta Title (Заголовок)')
                            ->maxLength(60)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('seo_description')
                            ->label('Meta Description (Описание)')
                            ->rows(3)
                            ->maxLength(160)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->select('products.*'))
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image')->label('Фото'),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category_custom')->label('Категория')->getStateUsing(fn (Product $record) => $record->category?->name),
                Tables\Columns\TextColumn::make('price')->money('kzt')->label('Цена')->sortable(),
                Tables\Columns\TextColumn::make('variants_sum_stock')->sum('variants', 'stock')->label('На складе (шт)')->badge()->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Активен')->sortable(),
                Tables\Columns\IconColumn::make('is_new')->boolean()->label('New')->trueIcon('heroicon-o-sparkles')->falseIcon('heroicon-o-minus')->color(fn ($state) => $state ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i')->label('Создан')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')->label('Категория')->options(Category::all()->pluck('name', 'id'))->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('products.created_at', 'desc');
    }
    
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}