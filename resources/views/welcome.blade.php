<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vernyi.est1921 - Уличный стиль Алматы</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .marquee-container { overflow: hidden; white-space: nowrap; }
        .marquee-content { display: inline-block; animation: marquee 20s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow pt-16">
        
        <section class="relative bg-[#0f172a] text-white overflow-hidden">
            <div class="absolute inset-0 opacity-40">
                <img src="https://images.unsplash.com/photo-1552168324-d612d77725e3?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 flex flex-col items-start justify-center">
                <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full mb-4 uppercase tracking-widest">Est. 1921 / Almaty</span>
                
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-4">
                    СТИЛЬ,<br>
                    СОЗДАННЫЙ<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">ДЛЯ УЛИЦ.</span>
                </h1>
                
                <p class="text-base text-gray-300 mb-8 max-w-lg leading-relaxed">
                    Новая коллекция одежды Vernyi уже здесь. Минимализм, качество и комфорт в каждой детали твоего образа.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('shop.index') }}" class="px-6 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition shadow-lg text-center text-sm">
                        Перейти в каталог
                    </a>
                    <a href="#new-arrivals" class="px-6 py-3 border border-white text-white font-bold rounded-full hover:bg-white hover:text-gray-900 transition text-center text-sm">
                        Смотреть новинки
                    </a>
                </div>
            </div>
        </section>

        <div class="bg-blue-600 text-white py-2 overflow-hidden marquee-container">
            <div class="marquee-content text-xs font-bold uppercase tracking-widest flex gap-12">
                <span>Новая коллекция</span> <span>•</span>
                <span>Бесплатная доставка от 20 000 ₸</span> <span>•</span>
                <span>Vernyi.est1921</span> <span>•</span>
                <span>Almaty Streetwear</span> <span>•</span>
                <span>Premium Quality</span> <span>•</span>
                <span>Новая коллекция</span> <span>•</span>
                <span>Бесплатная доставка от 20 000 ₸</span> <span>•</span>
                <span>Vernyi.est1921</span> <span>•</span>
                <span>Almaty Streetwear</span> <span>•</span>
                <span>Premium Quality</span>
            </div>
        </div>

        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center uppercase">Выбери свой стиль</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <a href="{{ route('shop.index', ['category' => 'xudi']) }}" class="group relative h-64 rounded-xl overflow-hidden shadow-md cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-xl font-bold text-white mb-0.5">Худи</h3>
                            <span class="text-xs text-gray-200 group-hover:underline">Смотреть &rarr;</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('shop.index', ['category' => 'futbolki']) }}" class="group relative h-64 rounded-xl overflow-hidden shadow-md cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-xl font-bold text-white mb-0.5">Футболки</h3>
                            <span class="text-xs text-gray-200 group-hover:underline">Смотреть &rarr;</span>
                        </div>
                    </a>

                    <a href="{{ route('shop.index', ['category' => 'shtany']) }}" class="group relative h-64 rounded-xl overflow-hidden shadow-md cursor-pointer">
                        <img src="https://img.joomcdn.net/2f034e7c4dbb2bede1e3a0730255cf6940d9d407_original.jpeg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-xl font-bold text-white mb-0.5">Штаны</h3>
                            <span class="text-xs text-gray-200 group-hover:underline">Смотреть &rarr;</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section id="new-arrivals" class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <span class="text-blue-600 font-bold uppercase tracking-wider text-xs">Свежий дроп</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Новинки</h2>
                    </div>
                    <a href="{{ route('shop.index') }}" class="hidden md:flex items-center text-sm font-bold text-gray-900 hover:text-blue-600 transition">
                        Смотреть всё
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-5 gap-y-8">
                    @foreach($newArrivals as $product)
                        <div class="group">
                            <div class="relative aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-3">
                                <a href="{{ route('product.show', $product->id) }}" class="block w-full h-full cursor-pointer">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs">Нет фото</div>
                                    @endif
                                </a>
                                
                                @if($product->is_new)
                                    <div class="absolute top-2 left-2 bg-white text-black text-[10px] font-bold px-1.5 py-0.5 rounded pointer-events-none">NEW</div>
                                @endif
                                
                                <div class="absolute bottom-0 left-0 right-0 p-2 translate-y-full group-hover:translate-y-0 transition duration-300 z-10">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <button type="submit" class="w-full bg-white text-gray-900 text-xs font-bold py-2.5 rounded-lg shadow-lg hover:bg-black hover:text-white transition">
                                            В корзину
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <h3 class="text-sm font-bold text-gray-900 leading-tight">
                                <a href="{{ route('product.show', $product->id) }}" class="hover:text-blue-600 transition">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-xs mt-1">{{ number_format($product->price, 0, ' ', ' ') }} ₸</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2 border border-gray-900 rounded-full text-sm font-bold">Смотреть всё</a>
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24 bg-gray-900 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                
                <div class="max-w-lg">
                    <span class="text-blue-500 font-bold uppercase tracking-widest text-xs mb-2 block">Concept Store & Local Brand</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">
                        Эпицентр <br>
                        уличного стиля.
                    </h2>
                    
                    <div class="text-gray-400 text-sm md:text-base leading-relaxed space-y-6">
                        <p>
                            <strong class="text-white">Vernyi.est1921</strong> — это больше, чем магазин. Это пространство, где история Алматы встречается с современной культурой.
                        </p>
                        <p>
                            Мы развиваем два направления:
                            <br>
                            1. <strong class="text-white">Собственная линейка Vernyi™</strong> — флагманская коллекция худи и футболок, которую мы производим сами из премиального хлопка. Контроль качества на каждом этапе.
                            <br>
                            2. <strong class="text-white">Селекция брендов</strong> — мы тщательно отбираем и привозим лучшие дропы от партнеров, близких нам по духу.
                        </p>
                        <p>
                            Твой стиль и комфорт — наш главный приоритет.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mt-8 pt-8 border-t border-gray-800">
                        <div>
                            <div class="text-3xl font-extrabold text-blue-500 mb-1">100%</div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Оригинал</div>
                        </div>
                        <div>
                            <div class="text-3xl font-extrabold text-blue-500 mb-1">KZ</div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Производство</div>
                        </div>
                    </div>
                </div>

                <div class="relative h-80 md:h-[500px] rounded-2xl overflow-hidden shadow-2xl group border border-gray-800">
                     <img src="{{ asset('images/vernyi-team.png') }}" 
                          class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700"
                          alt="Наша команда Vernyi">
                      
                      <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>

            </div>
        </section>

        <section class="py-12 bg-gray-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center uppercase">Отзывы</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=200&auto=format&fit=crop" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Алихан М.</h4>
                                <p class="text-[10px] text-gray-500 uppercase">г. Алматы</p>
                            </div>
                            <div class="ml-auto text-yellow-400 text-xs">★★★★★</div>
                        </div>
                        <p class="text-gray-600 text-xs leading-relaxed">
                            "Качество просто огонь! 🔥 Ткань плотная, капюшон держит форму. После стирки ничего не село."
                        </p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Алина К.</h4>
                                <p class="text-[10px] text-gray-500 uppercase">г. Астана</p>
                            </div>
                            <div class="ml-auto text-yellow-400 text-xs">★★★★★</div>
                        </div>
                        <p class="text-gray-600 text-xs leading-relaxed">
                            "Искала оверсайз футболку. Нашла у вас. Очень нравится минимализм. Доставили за 3 дня."
                        </p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&auto=format&fit=crop" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Данияр С.</h4>
                                <p class="text-[10px] text-gray-500 uppercase">г. Шымкент</p>
                            </div>
                            <div class="ml-auto text-yellow-400 text-xs">★★★★★</div>
                        </div>
                        <p class="text-gray-600 text-xs leading-relaxed">
                            "Бренд наш, Казахстанский, а качество на уровне мировых. Удачи вам!"
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-10 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div class="p-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">🚀</div>
                        <h3 class="font-bold text-sm mb-1">Быстрая доставка</h3>
                        <p class="text-gray-500 text-xs">По всему KZ за 2-5 дней.</p>
                    </div>
                    <div class="p-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">💎</div>
                        <h3 class="font-bold text-sm mb-1">Премиум качество</h3>
                        <p class="text-gray-500 text-xs">Только лучшие материалы.</p>
                    </div>
                    <div class="p-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">🛡️</div>
                        <h3 class="font-bold text-sm mb-1">Гарантия возврата</h3>
                        <p class="text-gray-500 text-xs">Обмен без проблем.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

    <div id="cart-toast" class="fixed bottom-5 right-5 bg-black text-white px-6 py-4 rounded-xl shadow-2xl transform translate-y-32 opacity-0 transition-all duration-300 z-50 flex items-center gap-3">
        <div class="bg-green-500 rounded-full p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-sm">Готово!</h4>
            <p class="text-xs text-gray-400">Товар добавлен в корзину</p>
        </div>
    </div>

    <style>
        #chat-widget { position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: sans-serif; }
        #chat-btn { background: #000; color: #fff; border: none; padding: 15px 20px; border-radius: 50px; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.2); font-weight: bold; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
        #chat-btn:hover { transform: scale(1.05); }
        #chat-box { display: none; width: 350px; height: 450px; background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.3); flex-direction: column; overflow: hidden; position: absolute; bottom: 70px; right: 0; }
        #chat-header { background: #000; color: #fff; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
        #chat-messages { flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; display: flex; flex-direction: column; gap: 10px; }
        .msg { max-width: 80%; padding: 10px; border-radius: 10px; font-size: 14px; line-height: 1.4; }
        .msg.bot { background: #e5e7eb; color: #000; align-self: flex-start; border-bottom-left-radius: 0; }
        .msg.user { background: #000; color: #fff; align-self: flex-end; border-bottom-right-radius: 0; }
        #chat-input-area { display: flex; border-top: 1px solid #eee; }
        #chat-input { flex: 1; border: none; padding: 15px; outline: none; }
        #chat-send { background: #fff; border: none; color: #000; font-weight: bold; padding: 0 20px; cursor: pointer; }
        .typing { font-size: 12px; color: #888; padding-left: 15px; display: none; }
    </style>

    <div id="chat-widget">
        <div id="chat-box">
            <div id="chat-header">
                <span>🤖 Vernyi Консультант</span>
                <span style="cursor:pointer;" onclick="toggleChat()">✕</span>
            </div>
            <div id="chat-messages">
                <div class="msg bot">Привет! 👋 Я ИИ-консультант. Подсказать что-то по худи или размерам?</div>
            </div>
            <div class="typing" id="typing-indicator">Печатает...</div>
            <div id="chat-input-area">
                <input type="text" id="chat-input" placeholder="Введите вопрос..." onkeypress="handleEnter(event)">
                <button id="chat-send" onclick="sendMessage()">➤</button>
            </div>
        </div>
        <button id="chat-btn" onclick="toggleChat()">
            💬 Помощник
        </button>
    </div>

    <script>
        // Глобальная переменная для хранения истории
        let chatHistory = [];

        function toggleChat() {
            const box = document.getElementById('chat-box');
            box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
        }

        function handleEnter(e) {
            if (e.key === 'Enter') sendMessage();
        }

        async function sendMessage() {
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if (!text) return;

            // Добавляем сообщение пользователя в интерфейс
            addMessage(text, 'user');
            input.value = '';
            
            // Показываем индикатор
            document.getElementById('typing-indicator').style.display = 'block';

            try {
                const response = await fetch('/chat', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    },
                    // 👇 ВАЖНО: Отправляем и новое сообщение, и историю!
                    body: JSON.stringify({ 
                        message: text,
                        history: chatHistory 
                    })
                });
                
                if (!response.ok) throw new Error('Ошибка сети');

                const data = await response.json();
                
                document.getElementById('typing-indicator').style.display = 'none';
                
                // Добавляем ответ бота
                addMessage(data.reply, 'bot');

                // 👇 СОХРАНЯЕМ В ИСТОРИЮ (Запоминаем диалог)
                // Добавляем вопрос пользователя
                chatHistory.push({ role: "user", parts: [{ text: text }] });
                // Добавляем ответ бота
                chatHistory.push({ role: "model", parts: [{ text: data.reply }] });

                // Ограничиваем историю (последние 10 сообщений), чтобы не перегружать
                if (chatHistory.length > 10) chatHistory = chatHistory.slice(-10);

            } catch (e) {
                document.getElementById('typing-indicator').style.display = 'none';
                console.error(e);
                addMessage('Ошибка соединения :(', 'bot');
            }
        }

        function addMessage(text, type) {
            const msgs = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = 'msg ' + type;
            div.innerHTML = text.replace(/\n/g, '<br>');
            msgs.appendChild(div);
            msgs.scrollTop = msgs.scrollHeight;
        }
    </script>
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = this.querySelector('button');
                const originalContent = button.innerHTML;
                button.innerHTML = '<div class="w-4 h-4 border-2 border-gray-300 border-t-black rounded-full animate-spin mx-auto"></div>';
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