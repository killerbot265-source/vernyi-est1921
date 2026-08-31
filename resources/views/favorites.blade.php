<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    @include('partials.header')

    <main class="container mx-auto px-4 py-8 flex-grow pt-24">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Мои Избранные товары ❤️</h1>

        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($favorites as $product)
                    <div class="bg-white rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full border border-gray-100 relative">
                        
                        <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                            @csrf
                            <button type="submit" class="bg-white/80 p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('product.show', $product->id) }}" class="block relative aspect-[3/4] overflow-hidden bg-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-sm">Нет фото</div>
                            @endif
                        </a>

                        <div class="p-4 flex flex-col flex-grow">
                            <a href="{{ route('product.show', $product->id) }}" class="flex-grow">
                                <h3 class="font-medium text-gray-900 text-base leading-tight hover:text-blue-600 transition mb-2">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div class="mt-auto pt-2 flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900">
                                    {{ number_format($product->price, 0, ' ', ' ') }} ₸
                                </span>
                                
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 text-xl mb-4">Ваш список избранного пуст 💔</p>
                <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full font-bold hover:bg-blue-700 transition">
                    Перейти к покупкам
                </a>
            </div>
        @endif
    </main>

</body>
</html>