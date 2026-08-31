<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen">

    @include('partials.header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24 flex-grow">
        
        <nav class="flex text-xs md:text-sm text-gray-500 mb-6 overflow-x-auto whitespace-nowrap">
            <a href="/" class="hover:text-black transition">Главная</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-black transition">Магазин</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16 items-start">
            
            <div class="w-full md:sticky md:top-24">
                <div class="bg-gray-100 rounded-xl overflow-hidden mb-4 relative shadow-sm border border-gray-100 flex justify-center items-center">
                    @if($product->image)
                        <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto max-h-[600px] object-contain cursor-zoom-in" alt="{{ $product->name }}">
                    @else
                        <div class="h-[400px] w-full flex items-center justify-center text-gray-400">Нет фото</div>
                    @endif
                    
                    @if($product->is_new)
                        <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">New</span>
                    @endif
                </div>

                <div class="grid grid-cols-5 gap-2">
                    @if($product->image)
                        <button onclick="swapImage('{{ asset('storage/' . $product->image) }}')" class="aspect-square rounded-lg overflow-hidden border-2 border-transparent hover:border-black transition p-0.5 focus:border-black">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-md">
                        </button>
                    @endif

                    @if($product->images->count() > 0)
                        @foreach($product->images as $imgModel)
                            <button onclick="swapImage('{{ asset('storage/' . $imgModel->image_path) }}')" class="aspect-square rounded-lg overflow-hidden border-2 border-transparent hover:border-black transition p-0.5 focus:border-black">
                                <img src="{{ asset('storage/' . $imgModel->image_path) }}" class="w-full h-full object-cover rounded-md">
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex flex-col" 
                 x-data="productSelector({{ $product->variants->toJson() }})">
                
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500 mb-4">Артикул: VRN-{{ $product->id }}</p>

                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-6">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 0, ' ', ' ') }} ₸</span>
                    
                    @auth
                        @php
                            $isFavorited = Auth::user()->favorites->contains($product->id);
                        @endphp
                        <form action="{{ route('favorite.toggle', $product->id) }}" method="POST">
                            @csrf
                            <button class="w-10 h-10 rounded-full flex items-center justify-center transition border border-gray-200 
                                {{ $isFavorited ? 'bg-red-50 text-red-500 border-red-200' : 'bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    @endauth
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mb-8">
                    @csrf
                    
                    <input type="hidden" name="color" :value="selectedColor">
                    <input type="hidden" name="size" :value="selectedSize">

                    <div class="mb-6" x-show="uniqueColors.length > 0">
                        <span class="text-sm font-bold text-gray-900 mb-2 block">Цвет: <span x-text="selectedColor" class="font-normal text-gray-500"></span></span>
                        <div class="flex flex-wrap gap-3">
                            <template x-for="color in uniqueColors" :key="color">
                                <button type="button" 
                                    @click="selectColor(color)"
                                    class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition relative"
                                    :class="selectedColor === color ? 'ring-2 ring-blue-500 ring-offset-2 border-transparent' : 'border-gray-200 hover:border-black'"
                                    :style="getColorStyle(color)"
                                    :title="color"
                                >
                                    <span x-show="!isStandardColor(color)" x-text="color.charAt(0).toUpperCase()" class="text-xs font-bold text-gray-500"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="mb-6" x-show="uniqueSizes.length > 0">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-bold text-gray-900">Размер</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="size in uniqueSizes" :key="size">
                                <button type="button"
                                    @click="selectedSize = size"
                                    :disabled="!isSizeAvailable(size)"
                                    class="min-w-[3rem] h-10 px-3 border rounded-md text-sm font-medium transition flex items-center justify-center"
                                    :class="{
                                        'bg-black text-white border-black': selectedSize === size,
                                        'bg-white text-gray-900 border-gray-200 hover:border-black': selectedSize !== size && isSizeAvailable(size),
                                        'bg-gray-100 text-gray-400 border-gray-100 cursor-not-allowed decoration-slice': !isSizeAvailable(size)
                                    }"
                                >
                                    <span x-text="size"></span>
                                </button>
                            </template>
                        </div>
                        <p x-show="selectedColor && !selectedSize" class="text-xs text-red-500 mt-2">Выберите размер</p>
                    </div>

                    <button type="submit" 
                        :disabled="!canAddToCart"
                        :class="canAddToCart ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-100' : 'bg-gray-300 cursor-not-allowed'"
                        class="w-full text-white font-bold py-3.5 rounded-xl transition shadow-lg flex items-center justify-center gap-2 text-lg">
                        <span x-text="canAddToCart ? 'Добавить в корзину' : 'Выберите параметры'"></span>
                    </button>
                    
                    <p x-show="currentStock > 0 && currentStock < 5" class="text-xs text-orange-500 mt-2 text-center">
                        Осталось всего <span x-text="currentStock"></span> шт.
                    </p>
                </form>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Характеристики</h3>
                    @if($product->specifications)
                        <div class="grid grid-cols-1 gap-y-3 text-sm">
                            @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between border-b border-gray-50 pb-2 last:border-0">
                                    <span class="text-gray-500">{{ $key }}</span>
                                    <span class="text-gray-900 font-medium text-right">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                         <p class="text-gray-400 text-sm">Нет характеристик</p>
                    @endif

                    @if($product->description)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-2 text-sm uppercase tracking-wide">Описание</h3>
                        <div class="text-gray-600 text-sm leading-relaxed prose prose-sm">
                            {!! $product->description !!}
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="mt-20 border-t border-gray-100 pt-10">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Смотрите также</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($similarProducts as $related)
                <div class="group">
                    <a href="{{ route('product.show', $related->id) }}" class="block relative aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-2">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                             <div class="flex items-center justify-center h-full text-gray-400 text-xs">Нет фото</div>
                        @endif
                    </a>
                    <h3 class="text-sm font-bold text-gray-900 truncate">
                        <a href="{{ route('product.show', $related->id) }}">{{ $related->name }}</a>
                    </h3>
                    <p class="text-gray-500 text-xs mt-0.5">{{ number_format($related->price, 0, ' ', ' ') }} ₸</p>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @include('partials.footer')

    <div id="cart-toast" class="fixed bottom-5 right-5 bg-black text-white px-6 py-4 rounded-xl shadow-2xl transform translate-y-32 opacity-0 transition-all duration-300 z-50 flex items-center gap-3">
        <div class="bg-green-500 rounded-full p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
        </div>
        <div>
            <h4 class="font-bold text-sm">Готово!</h4>
            <p class="text-xs text-gray-400">Товар добавлен в корзину</p>
        </div>
    </div>

    <script>
        // Функция замены фото (твоя)
        function swapImage(src) {
            document.getElementById('mainImage').src = src;
        }

        // Логика выбора вариантов (Alpine.js)
        document.addEventListener('alpine:init', () => {
            Alpine.data('productSelector', (variants) => ({
                variants: variants,
                selectedColor: null,
                selectedSize: null,

                init() {
                    // Если вариантов нет, ничего не делаем
                    if (this.variants.length === 0) return;
                    
                    // Автоматически выбираем первый доступный цвет
                    const firstAvailable = this.variants.find(v => v.stock > 0);
                    if (firstAvailable) {
                        this.selectColor(firstAvailable.color);
                    }
                },

                // Уникальные цвета для кнопок
                get uniqueColors() {
                    return [...new Set(this.variants.map(v => v.color))].filter(Boolean);
                },

                // Уникальные размеры (ВООБЩЕ ВСЕ возможные для этого товара)
                get uniqueSizes() {
                     // Можно показывать только размеры для выбранного цвета, 
                     // но лучше показывать все и дизейблить недоступные
                     return [...new Set(this.variants.map(v => v.size))].filter(Boolean);
                },

                // Остаток выбранной комбинации
                get currentStock() {
                    if (!this.selectedColor || !this.selectedSize) return 0;
                    const variant = this.variants.find(v => v.color === this.selectedColor && v.size === this.selectedSize);
                    return variant ? variant.stock : 0;
                },

                // Можно ли нажать кнопку купить?
                get canAddToCart() {
                    return this.selectedColor && this.selectedSize && this.currentStock > 0;
                },

                selectColor(color) {
                    this.selectedColor = color;
                    // Сбрасываем размер, если выбранный размер недоступен в новом цвете
                    if (this.selectedSize && !this.isSizeAvailable(this.selectedSize)) {
                        this.selectedSize = null;
                    }
                },

                // Проверка: есть ли такой размер в выбранном цвете и есть ли он на складе
                isSizeAvailable(size) {
                    if (!this.selectedColor) return false;
                    const variant = this.variants.find(v => v.color === this.selectedColor && v.size === size);
                    return variant && variant.stock > 0;
                },

                // Цвета для кружочков (стили)
                getColorStyle(colorName) {
                    const map = {
                        'black': '#000', 'черный': '#000',
                        'white': '#fff', 'белый': '#fff',
                        'gray': '#6b7280', 'серый': '#6b7280',
                        'red': '#dc2626', 'красный': '#dc2626',
                        'blue': '#2563eb', 'синий': '#2563eb',
                        'green': '#16a34a', 'зеленый': '#16a34a',
                        'beige': '#f5f5dc', 'бежевый': '#f5f5dc'
                    };
                    const hex = map[colorName.toLowerCase()] || null;
                    return hex ? `background-color: ${hex};` : '';
                },

                isStandardColor(colorName) {
                    const map = ['black','черный','white','белый','gray','серый','red','красный','blue','синий','green','зеленый','beige','бежевый'];
                    return map.includes(colorName.toLowerCase());
                }
            }));
        });

        // Отправка формы (твоя, немного адаптированная)
        document.querySelector('.add-to-cart-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            button.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
            button.disabled = true;

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                const counter = document.getElementById('cart-count');
                if(counter) counter.innerText = data.cart_count;
                const toast = document.getElementById('cart-toast');
                toast.classList.remove('translate-y-32', 'opacity-0');
                setTimeout(() => { toast.classList.add('translate-y-32', 'opacity-0'); }, 3000);
            })
            .catch(error => console.error('Ошибка:', error))
            .finally(() => {
                button.innerHTML = originalContent;
                // Кнопка остается заблокированной только если товара больше нет? 
                // Нет, разблокируем, вдруг пользователь хочет купить 2 штуки.
                // Но надо проверить Alpine state, поэтому просто вернем текст.
                // Логику блокировки управляет Alpine.
                button.disabled = false; 
            });
        });
    </script>
</body>
</html>