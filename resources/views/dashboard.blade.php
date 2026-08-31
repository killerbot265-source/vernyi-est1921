<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">📦 История заказов</h3>
                        <span class="text-sm text-gray-500">Всего заказов: {{ Auth::user()->orders->count() }}</span>
                    </div>

                    @if(Auth::user()->orders->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr class="text-gray-500 text-sm uppercase tracking-wider">
                                        <th class="py-4 px-6 font-medium">№</th>
                                        <th class="py-4 px-6 font-medium">Дата</th>
                                        <th class="py-4 px-6 font-medium">Статус</th>
                                        <th class="py-4 px-6 font-medium text-right">Сумма</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach(Auth::user()->orders as $order)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-4 px-6 font-bold text-blue-600">
                                                #{{ $order->id }}
                                            </td>
                                            <td class="py-4 px-6 text-gray-600 text-sm">
                                                {{ $order->created_at->format('d.m.Y в H:i') }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                                    {{ $order->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                                ">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 font-bold text-gray-900 text-right">
                                                {{ number_format($order->total_price, 0, ' ', ' ') }} ₸
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-gray-500 text-lg mb-6">Вы еще ничего не заказывали 😔</p>
                            <a href="{{ route('shop.index') }}" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-600 transition shadow-lg">
                                Перейти к покупкам
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>