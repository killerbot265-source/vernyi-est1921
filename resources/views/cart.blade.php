<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Корзина - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(0, 0, 0, 0.1); border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    @php
        // 👇 ВЫНЕСЛИ РАСЧЕТЫ В САМЫЙ ВЕРХ, ЧТОБЫ НЕ БЫЛО ОШИБОК
        $subtotal = 0;
        $shippingCost = 0;
        $grandTotal = 0;

        if(session('cart')) {
            foreach(session('cart') as $details) {
                $subtotal += $details['price'] * $details['quantity'];
            }
            // Логика доставки: бесплатно от 30 000
            $shippingCost = ($subtotal >= 30000) ? 0 : 2500;
            $grandTotal = $subtotal + $shippingCost;
        }
    @endphp

    @include('partials.header')

    <div class="container mx-auto px-4 py-8 pt-28 max-w-6xl">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Моя корзина</h1>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="flex flex-col lg:flex-row gap-8" id="cart-container">
                
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4 font-medium">Товар</th>
                                    <th class="px-6 py-4 font-medium text-center">Кол-во</th>
                                    <th class="px-6 py-4 font-medium text-right">Цена</th>
                                    <th class="px-6 py-4 font-medium text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach(session('cart') as $key => $details)
                                    <tr class="hover:bg-gray-50 transition cart-row" data-id="{{ $key }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0 relative">
                                                    @if(isset($details['image']))
                                                        <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs">Нет фото</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-sm md:text-base">{{ $details['name'] }}</h3>
                                                    <div class="flex flex-col gap-1 mt-1">
                                                        @if(isset($details['color']) && $details['color'])
                                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded w-fit">Цвет: {{ $details['color'] }}</span>
                                                        @endif
                                                        @if(isset($details['size']) && $details['size'])
                                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded w-fit">Размер: {{ $details['size'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center border border-gray-200 rounded-lg bg-white">
                                                <button class="update-cart px-3 py-1 text-gray-600 hover:bg-gray-100 hover:text-blue-600 transition text-lg font-bold" 
                                                        data-action="decrease" data-id="{{ $key }}">−</button>
                                                <input type="number" value="{{ $details['quantity'] }}" 
                                                       class="w-10 text-center text-sm font-bold text-gray-900 border-none focus:ring-0 p-0 quantity-input" readonly>
                                                <button class="update-cart px-3 py-1 text-gray-600 hover:bg-gray-100 hover:text-blue-600 transition text-lg font-bold" 
                                                        data-action="increase" data-id="{{ $key }}">+</button>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right font-bold text-gray-900 text-lg whitespace-nowrap item-total-price">
                                            {{ number_format($details['price'] * $details['quantity'], 0, ' ', ' ') }} ₸
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <button class="remove-btn-trigger text-gray-400 hover:text-red-500 transition p-2 rounded-full hover:bg-red-50" data-id="{{ $key }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Вернуться в магазин
                        </a>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-28">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Сумма заказа</h2>

                        <div class="flex justify-between items-center mb-3 text-gray-600">
                            <span id="cart-items-count">Товары ({{ count(session('cart')) }})</span>
                            <span class="js-subtotal font-medium">{{ number_format($subtotal, 0, ' ', ' ') }} ₸</span>
                        </div>

                        <div class="flex justify-between items-center mb-2 text-gray-600">
                            <span>Доставка</span>
                            @if($shippingCost > 0)
                                <span class="js-shipping-text text-gray-900 font-bold">+ {{ number_format($shippingCost, 0, ' ', ' ') }} ₸</span>
                            @else
                                <span class="js-shipping-text text-green-600 font-bold">Бесплатно</span>
                            @endif
                        </div>

                        <div class="js-marketing-alert mb-4 p-2 bg-yellow-50 text-yellow-800 text-xs rounded-lg border border-yellow-100 {{ $shippingCost == 0 ? 'hidden' : '' }}">
                            💡 Добавьте товаров еще на 
                            <span class="js-diff-amount font-bold">{{ number_format(30000 - $subtotal, 0, ' ', ' ') }} ₸</span>, 
                            чтобы доставка стала бесплатной!
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-8 flex justify-between items-center">
                            <span class="text-2xl font-bold text-gray-900">Итого:</span>
                            <span class="js-grand-total text-2xl font-bold text-blue-600">{{ number_format($grandTotal, 0, ' ', ' ') }} ₸</span>
                        </div>

                        <button onclick="openCheckoutModal()" class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg flex justify-center items-center gap-2 transform active:scale-95">
                            <span>Перейти к оформлению</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                        
                        <p class="text-xs text-gray-400 text-center mt-4">
                            Нажимая кнопку, вы соглашаетесь с условиями оферты
                        </p>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Ваша корзина пуста</h2>
                <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-700 transition shadow-lg mt-4">
                    Перейти в каталог
                </a>
            </div>
        @endif
    </div>

    <div id="delete-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="delete-modal-backdrop"></div>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full transform scale-95 opacity-0 transition-all duration-300 p-8 text-center" id="delete-modal-panel">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Удалить товар?</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">Вы уверены, что хотите убрать эту вещь из корзины?</p>
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="closeDeleteModal()" class="w-full py-3 px-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-black transition">Отмена</button>
                    <button id="confirm-delete-btn" class="w-full py-3 px-4 bg-black text-white rounded-xl text-sm font-bold shadow-lg hover:bg-gray-900 transition flex justify-center items-center gap-2"><span>Удалить</span></button>
                </div>
            </div>
        </div>
    </div>

    <div id="checkout-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="checkout-modal-backdrop"></div>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full transform scale-95 opacity-0 transition-all duration-300 p-8 max-h-[90vh] overflow-y-auto custom-scrollbar" id="checkout-modal-panel">
                <button onclick="closeCheckoutModal()" class="absolute top-5 right-5 text-gray-400 hover:text-black transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg></div>
                    <h2 class="text-2xl font-bold text-gray-900">Оформление заказа</h2>
                    <p class="text-sm text-gray-500 mt-2">Заполните данные для доставки</p>
                </div>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="space-y-4"> 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2 ml-1">Имя</label><input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:border-black transition" placeholder="Ваше имя"></div>
                            <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2 ml-1">Телефон</label><input type="text" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:border-black transition" placeholder="+7 (___) ___-__-__"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2 ml-1">Город</label><div class="relative"><span class="absolute left-4 top-3.5 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg></span><input type="text" name="city" required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:bg-white focus:border-black transition" placeholder="Алматы"></div></div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2 ml-1">Адрес доставки</label><div class="relative"><span class="absolute left-4 top-3.5 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg></span><input type="text" name="address" required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:bg-white focus:border-black transition" placeholder="Улица, дом, квартира"></div></div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2 ml-1">Комментарий курьеру</label><textarea name="comment" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:border-black transition resize-none" placeholder="Код домофона, этаж..."></textarea></div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col gap-3">
                        <div class="flex justify-between items-center text-sm font-medium mb-2">
                            <span class="text-gray-500">К оплате (с доставкой):</span>
                            <span class="js-grand-total text-xl font-bold text-gray-900 cart-total-price">{{ number_format($grandTotal, 0, ' ', ' ') }} ₸</span>
                        </div>
                        <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg flex justify-center items-center gap-2"><span>Перейти к оплате</span><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg></button>
                        <button type="button" onclick="closeCheckoutModal()" class="w-full text-gray-500 font-bold py-3 hover:text-black transition">Вернуться назад</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function formatMoney(amount) {
            return new Intl.NumberFormat('ru-RU').format(amount) + ' ₸';
        }

        $(".update-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            var id = ele.attr("data-id");
            var action = ele.attr("data-action");
            var row = ele.closest('tr');
            
            var input = ele.siblings('.quantity-input');
            var currentQty = parseInt(input.val());
            var newQty = currentQty;

            if (action === 'increase') newQty = currentQty + 1;
            else if (action === 'decrease') newQty = currentQty - 1;

            if(newQty < 1) return;

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "patch",
                data: { _token: $('meta[name="csrf-token"]').attr('content'), id: id, quantity: newQty },
                success: function (response) {
                    if(response.success) {
                        input.val(newQty);
                        row.find('.item-total-price').text(response.item_total);
                        
                        var subtotalStr = response.cart_total.replace(/[^0-9]/g, ''); 
                        var subtotal = parseInt(subtotalStr);
                        var shipping = (subtotal >= 30000) ? 0 : 2500;
                        var grandTotal = subtotal + shipping;

                        $('.js-subtotal').text(formatMoney(subtotal));
                        
                        if(shipping > 0) {
                            $('.js-shipping-text').removeClass('text-green-600').addClass('text-gray-900').text('+ ' + formatMoney(shipping));
                            $('.js-marketing-alert').removeClass('hidden');
                            $('.js-diff-amount').text(formatMoney(30000 - subtotal));
                        } else {
                            $('.js-shipping-text').removeClass('text-gray-900').addClass('text-green-600').text('Бесплатно');
                            $('.js-marketing-alert').addClass('hidden');
                        }

                        $('.js-grand-total').text(formatMoney(grandTotal));
                    }
                }
            });
        });

        let deleteItemId = null;
        $(".remove-btn-trigger").click(function (e) { e.preventDefault(); deleteItemId = $(this).attr("data-id"); openDeleteModal(); });
        function openDeleteModal() { const modal = document.getElementById('delete-modal'); const backdrop = document.getElementById('delete-modal-backdrop'); const panel = document.getElementById('delete-modal-panel'); modal.classList.remove('hidden'); setTimeout(() => { backdrop.classList.remove('opacity-0'); panel.classList.remove('scale-95', 'opacity-0'); panel.classList.add('scale-100', 'opacity-100'); }, 10); }
        function closeDeleteModal() { const modal = document.getElementById('delete-modal'); const backdrop = document.getElementById('delete-modal-backdrop'); const panel = document.getElementById('delete-modal-panel'); backdrop.classList.add('opacity-0'); panel.classList.remove('scale-100', 'opacity-100'); panel.classList.add('scale-95', 'opacity-0'); setTimeout(() => { modal.classList.add('hidden'); deleteItemId = null; }, 300); }
        $("#confirm-delete-btn").click(function () {
            if (deleteItemId) {
                $(this).html('<div class="w-4 h-4 border-2 border-gray-400 border-t-white rounded-full animate-spin"></div>');
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: "DELETE",
                    data: { _token: $('meta[name="csrf-token"]').attr('content'), id: deleteItemId },
                    success: function (response) {
                         window.location.reload();
                    }
                });
            }
        });
        document.getElementById('delete-modal-backdrop').addEventListener('click', closeDeleteModal);

        function openCheckoutModal() { const modal = document.getElementById('checkout-modal'); const backdrop = document.getElementById('checkout-modal-backdrop'); const panel = document.getElementById('checkout-modal-panel'); modal.classList.remove('hidden'); setTimeout(() => { backdrop.classList.remove('opacity-0'); panel.classList.remove('scale-95', 'opacity-0'); panel.classList.add('scale-100', 'opacity-100'); }, 10); }
        function closeCheckoutModal() { const modal = document.getElementById('checkout-modal'); const backdrop = document.getElementById('checkout-modal-backdrop'); const panel = document.getElementById('checkout-modal-panel'); backdrop.classList.add('opacity-0'); panel.classList.remove('scale-100', 'opacity-100'); panel.classList.add('scale-95', 'opacity-0'); setTimeout(() => { modal.classList.add('hidden'); }, 300); }
        document.getElementById('checkout-modal-backdrop').addEventListener('click', closeCheckoutModal);
    </script>

</body>
</html>