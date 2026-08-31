<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ #{{ $order->id }} - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <header>
        @include('partials.header')
    </header>

    <main class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            
            <div class="bg-gray-900 text-white p-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Заказ #{{ $order->id }}</h1>
                    <p class="text-gray-400 text-sm">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <div class="px-3 py-1 rounded bg-white/10 text-white font-bold text-sm">
                    {{ $order->status }}
                </div>
            </div>

            <div class="p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Список товаров</h3>
                
                <div class="space-y-4 mb-8">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs text-gray-400">Нет фото</div>
                                    @endif
                                </div>
                                
                                <div>
                                    <p class="font-bold text-gray-900">{{ $item->product->name ?? 'Товар удален' }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($item->price, 0, ' ', ' ') }} ₸ x {{ $item->quantity }} шт.</p>
                                </div>
                            </div>
                            
                            <div class="font-bold text-gray-800">
                                {{ number_format($item->price * $item->quantity, 0, ' ', ' ') }} ₸
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 flex justify-between items-center text-xl">
                    <span class="font-bold text-gray-600">Итого к оплате:</span>
                    <span class="font-extrabold text-blue-600">{{ number_format($order->total_price, 0, ' ', ' ') }} ₸</span>
                </div>

                <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-sm text-gray-500 uppercase mb-2">Данные доставки</h4>
                    <p class="text-gray-900"><strong>Имя:</strong> {{ $order->customer_name }}</p>
                    <p class="text-gray-900"><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>