<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        
        input[type="checkbox"]:checked {
            background-color: black;
            border-color: black;
        }

        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white flex flex-col min-h-screen font-sans text-gray-900">

    @include('partials.header')

    <main class="w-full px-4 md:px-8 py-6 flex-grow pt-24">
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4 h-auto md:h-12">
            
            <div class="flex items-center gap-3 shrink-0">
                <h1 class="text-xl font-extrabold text-gray-900 leading-none">
                    Каталог
                </h1>
                <span class="text-gray-400 text-[10px] font-bold bg-gray-100 px-2 py-0.5 rounded-full">{{ $products->total() }}</span>
            </div>

            <div class="flex-grow min-w-0 px-4 w-full md:w-auto">
                @if(request('categories') || request('min_price') || request('max_price') || request('search'))
                    <div class="flex items-center gap-2 overflow-x-auto hide-scroll whitespace-nowrap">
                        
                        @if(request('search'))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 shrink-0">
                                Поиск: "{{ request('search') }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-1.5 text-blue-400 hover:text-blue-700 cursor-pointer">✕</a>
                            </span>
                        @endif

                        @if(request('categories'))
                            @foreach(request('categories') as $slug)
                                @php $cat = $categories->firstWhere('slug', $slug); @endphp
                                @if($cat)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-black text-white border border-black shrink-0">
                                        {{ $cat->name }}
                                        <a href="{{ route('shop.index', array_merge(request()->except('categories'), ['categories' => array_diff(request('categories'), [$slug])])) }}" class="ml-1.5 text-gray-400 hover:text-white cursor-pointer">✕</a>
                                    </span>
                                @endif
                            @endforeach
                        @endif

                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-white text-gray-700 border border-gray-300 shrink-0">
                                {{ request('min_price', 0) }} - {{ request('max_price', '∞') }} ₸
                                <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="ml-1.5 text-gray-400 hover:text-red-500 cursor-pointer">✕</a>
                            </span>
                        @endif
                        
                        <a href="{{ route('shop.index') }}" class="text-[10px] font-bold text-red-500 hover:text-red-700 ml-2 border-b border-dashed border-red-300 hover:border-red-700 shrink-0 whitespace-nowrap">
                            Сбросить всё
                        </a>
                    </div>
                @else
                    <div class="h-6"></div>
                @endif
            </div>

            <div class="shrink-0 w-full md:w-auto">
                <form id="sortForm" method="GET">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v) <input type="hidden" name="{{ $key }}[]" value="{{ $v }}"> @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="bg-white border border-gray-200 text-gray-700 text-xs rounded-lg focus:ring-black focus:border-black block w-full md:w-40 p-2 cursor-pointer hover:bg-gray-50 transition">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала дешевые</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="flex gap-6 items-start relative">
            
            <aside class="hidden md:block w-48 flex-shrink-0 sticky top-24 h-[calc(100vh-100px)] overflow-y-auto custom-scroll pr-2">
                <form action="{{ route('shop.index') }}" method="GET">
                    
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <div class="mb-8">
                        <h3 class="font-bold text-[11px] text-gray-900 uppercase tracking-widest mb-3 border-b border-gray-100 pb-1">Категории</h3>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer group select-none">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="categories[]" value="{{ $category->slug }}" 
                                            class="peer appearance-none w-4 h-4 border border-gray-300 rounded bg-white checked:bg-black checked:border-black transition cursor-pointer"
                                            {{ in_array($category->slug, (array)request('categories', [])) ? 'checked' : '' }}>
                                        <svg class="absolute w-3 h-3 text-white hidden peer-checked:block pointer-events-none left-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-600 group-hover:text-black transition">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-[11px] text-gray-900 uppercase tracking-widest mb-3 border-b border-gray-100 pb-1">Цена</h3>
                        <div class="flex flex-col gap-2">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">от</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                       class="w-full pl-8 pr-2 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-black focus:border-black bg-white" placeholder="0">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">до</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       class="w-full pl-8 pr-2 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-black focus:border-black bg-white" placeholder="100 000">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-bold py-2.5 rounded-lg hover:bg-gray-800 transition text-xs shadow-md">
                        Применить
                    </button>
                </form>
            </aside>

            <div class="flex-grow w-full min-w-0">
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-4 gap-y-8">
                        @foreach($products as $product)
                            <div class="bg-white group flex flex-col h-full relative">
                                <a href="{{ route('product.show', $product->id) }}" class="relative aspect-[3/4] block overflow-hidden rounded-lg bg-gray-100 mb-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs">Нет фото</div>
                                    @endif
                                    
                                    @if($product->is_new)
                                        <span class="absolute top-2 left-2 bg-white text-black text-[10px] font-bold px-1.5 py-0.5 rounded pointer-events-none">NEW</span>
                                    @endif

                                    <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition duration-300 translate-y-2 group-hover:translate-y-0">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center hover:bg-gray-800 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </a>

                                <div class="flex flex-col flex-grow">
                                    <p class="text-[9px] text-gray-400 mb-0.5 uppercase tracking-wider truncate">{{ $product->category->name }}</p>
                                    <h3 class="text-xs font-bold text-gray-900 mb-1 leading-snug line-clamp-2 hover:text-blue-600">
                                        <a href="{{ route('product.show', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <div class="mt-auto">
                                        <span class="text-sm font-medium text-gray-900">{{ number_format($product->price, 0, ' ', ' ') }} ₸</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-24 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div class="text-4xl mb-4 text-gray-300">🔍</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Пусто</h3>
                        <p class="text-xs text-gray-500 mb-6">Товаров по запросу "{{ request('search') }}" не найдено.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-black text-white text-xs px-5 py-2 rounded-full font-bold hover:bg-gray-800 transition">Сбросить фильтры</a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('partials.footer')
    
    <div id="cart-toast" class="fixed bottom-5 right-5 bg-black text-white px-5 py-3 rounded-lg shadow-2xl transform translate-y-32 opacity-0 transition-all duration-300 z-50 flex items-center gap-3">
        <div class="text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        </div>
        <div><h4 class="font-bold text-xs">Добавлено!</h4></div>
    </div>

    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                const button = this.querySelector('button');
                const originalContent = button.innerHTML;
                button.innerHTML = '<div class="w-3 h-3 border-2 border-gray-400 border-t-white rounded-full animate-spin"></div>';
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
                    button.disabled = false;
                });
            });
        });
    </script>
</body>
</html>