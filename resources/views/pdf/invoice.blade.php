<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ №{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 p-10 print:p-0 print:bg-white font-sans text-gray-800">

    <div class="max-w-2xl mx-auto bg-white p-10 shadow-lg rounded-xl print:shadow-none print:p-0">
        
        <div class="flex justify-between items-start mb-8 border-b pb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-wide">Накладная</h1>
                <p class="text-gray-500 mt-1">Заказ №{{ $order->id }}</p>
                <p class="text-sm text-gray-400 mt-1">от {{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold">VERNYI SHOP</h2>
                <p class="text-sm text-gray-500">+7 701 654 54 23</p>
                <p class="text-sm text-gray-500">vernyi.est1921@gmail.com</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Получатель</h3>
                <p class="font-bold text-lg">{{ $order->customer_name }}</p>
                <p class="text-gray-600">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Доставка</h3>
                <p class="text-gray-800">{{ $order->city ?? 'Город не указан' }}</p>
                <p class="text-gray-600">{{ $order->address ?? 'Самовывоз' }}</p>
                @if($order->comment)
                    <p class="text-xs text-red-500 mt-1 italic">"{{ $order->comment }}"</p>
                @endif
            </div>
        </div>

        <table class="w-full mb-8 border-collapse">
            <thead>
                <tr class="bg-gray-50 text-left text-xs uppercase text-gray-500 border-b border-gray-200">
                    <th class="py-3 px-4">Товар</th>
                    <th class="py-3 px-4 text-center">Кол-во</th>
                    <th class="py-3 px-4 text-right">Цена</th>
                    <th class="py-3 px-4 text-right">Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b border-gray-100">
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-800">{{ $item->product->name ?? 'Удаленный товар' }}</p>
                        </td>
                    <td class="py-4 px-4 text-center">{{ $item->quantity }}</td>
                    <td class="py-4 px-4 text-right whitespace-nowrap">{{ number_format($item->price, 0, ' ', ' ') }} ₸</td>
                    <td class="py-4 px-4 text-right font-bold whitespace-nowrap">{{ number_format($item->price * $item->quantity, 0, ' ', ' ') }} ₸</td>
                </tr>
                @endforeach
            </tbody>
        </table>

<div class="flex justify-end mb-12">
            <div class="text-right w-1/2">
                
                @php
                    // 1. Считаем сумму чисто за товары
                    $itemsSum = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    
                    // 2. Вычисляем сколько стоила доставка (Общая сумма - Товары)
                    $shipping = $order->total_price - $itemsSum;
                @endphp

                <div class="flex justify-between py-2 text-gray-500">
                    <span>Сумма товаров:</span>
                    <span>{{ number_format($itemsSum, 0, ' ', ' ') }} ₸</span>
                </div>

                <div class="flex justify-between py-2 text-gray-500 border-t">
                    <span>Доставка:</span>
                    @if($shipping > 0)
                        <span>{{ number_format($shipping, 0, ' ', ' ') }} ₸</span>
                    @else
                        <span class="text-green-600 font-bold">Бесплатно</span>
                    @endif
                </div>

                <div class="flex justify-between py-4 text-2xl font-bold text-gray-900 border-t border-black">
                    <span>Итого к оплате:</span>
                    <span>{{ number_format($order->total_price, 0, ' ', ' ') }} ₸</span>
                </div>

            </div>
        </div> 

        <div class="border-t pt-6 text-center text-sm text-gray-400">
            <p>Спасибо за покупку!</p>
            <p class="mt-1">В случае вопросов обращайтесь в поддержку.</p>
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                🖨️ Распечатать / Сохранить PDF
            </button>
            <p class="text-xs text-gray-400 mt-2">Совет: В окне печати выберите "Сохранить как PDF"</p>
        </div>

    </div>

</body>
</html>