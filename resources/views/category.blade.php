<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header>
        @include('partials.header')
    </header>

    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <main class="flex-grow container mx-auto px-4 py-8">
        
        <div class="bg-blue-600 rounded-xl p-8 mb-10 text-center text-white shadow-lg">
            <h1 class="text-4xl font-bold mb-2">Новая коллекция</h1>
            <p class="text-blue-100">Стиль и качество в каждой детали.</p>
        </div>

        <div class="mb-8">
            <a href="/" class="text-gray-500 hover:text-blue-600 mb-2 inline-block">&larr; Назад на главную</a>
            <h1 class="text-3xl font-bold text-gray-900">
                Категория: <span class="text-blue-600">{{ $category->name }}</span>
            </h1>
            <p class="text-gray-600 mt-2">Найдено товаров: {{ $products->count() }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">

                    <a href="{{ route('product.show', $product->id) }}">
                        <div class="h-64 overflow-hidden bg-gray-100 relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">Нет фото</div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-lg font-bold text-blue-600">{{ number_format($product->price, 0, ' ', ' ') }} ₸</span>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-gray-100 rounded-full hover:bg-blue-600 hover:text-white transition group-hover:bg-blue-600 group-hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <footer class="bg-white border-t mt-12 py-6">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 Vernyi.est1921. Все права защищены.
        </div>
    </footer>

</body>
</html>