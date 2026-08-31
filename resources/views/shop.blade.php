<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('partials.header')

    <main class="w-full px-4 md:px-8 py-8 flex-grow pt-24">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-8">
                    
                    <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                        
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <div class="mb-8">
                            <h3 class="font-bold text-lg mb-4 text-gray-900">Категории</h3>
                            <ul class="space-y-2 text-sm">
                                <li>
                                    <a href="{{ route('shop.index') }}" 
                                       class="block hover:text-blue-600 transition {{ !request('category') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                        Все товары
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('shop.index', array_merge(request()->except('category'), ['category' => $cat->slug])) }}" 
                                           class="block hover:text-blue-600 transition {{ request('category') == $cat->slug ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mb-8">
                            <h3 class="font-bold text-lg mb-4 text-gray-900">Цена (₸)</h3>
                            <div class="flex gap-2 items-center mb-4">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="От" 
                                       class="w-full border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="До" 
                                       class="w-full border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded-md text-sm font-bold hover:bg-blue-600 transition">
                                Применить
                            </button>
                            
                            @if(request('min_price') || request('max_price'))
                                <a href="{{ route('shop.index', ['category' => request('category')]) }}" class="block text-center text-xs text-gray-400 mt-2 hover:text-red-500">
                                    Сбросить цену
                                </a>
                            @endif
                        </div>
                    </form>

                </div>
            </aside>

            <section class="flex-grow">
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">
                        @if(request('search'))
                            Результаты поиска: "<span class="text-blue-600">{{ request('search') }}</span>"
                        @elseif(request('category'))
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Категория' }}
                        @else
                            Все товары
                        @endif
                        <span class="text-gray-400 text-lg font-normal ml-2">{{ $products->count() }}</span>
                    </h1>

                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Сортировать:</span>
                        <select onchange="document.getElementById('sortInput').value=this.value; document.getElementById('filterForm').submit();" 
                                class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала дешевые</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                        </select>
                        <input type="hidden" name="sort" id="sortInput" form="filterForm" value="{{ request('sort') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full border border-gray-100">
                            
                            <a href="{{ route('product.show', $product->id) }}" class="block relative aspect-[3/4] overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-sm font-medium">Нет фото</div>
                                @endif
                                
                                @if($product->created_at->diffInDays() < 7)
                                    <span class="absolute top-2 left-2 bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wide">New</span>
                                @endif
                            </a>

                            <div class="p-4 flex flex-col flex-grow">
                                <p class="text-xs text-gray-400 mb-1">{{ $product->category->name ?? 'Коллекция' }}</p>
                                <a href="{{ route('product.show', $product->id) }}" class="flex-grow">
                                    <h3 class="font-medium text-gray-900 text-base leading-tight hover:text-blue-600 transition mb-2">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                                                
                                <div class="mt-auto pt-2 flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">
                                        {{ number_format($product->price, 0, ' ', ' ') }} ₸
                                    </span>
                                    
                                    <div class="flex gap-2">
                                        @auth
                                            <form action="{{ route('favorite.toggle', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-full flex items-center justify-center transition border {{ $product->isFavorited() ? 'bg-red-50 border-red-200 text-red-500' : 'bg-white border-gray-200 text-gray-400 hover:text-red-500' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $product->isFavorited() ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endauth

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center hover:bg-blue-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-32">
                            <p class="text-gray-500 text-lg">Товаров по вашему запросу не найдено 😔</p>
                            <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Сбросить фильтры</a>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
</body>
</html>