<footer class="bg-black text-white pt-16 pb-8 border-t border-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            
            <div class="space-y-6">
                <a href="/" class="text-2xl font-bold tracking-tighter block">
                    Vernyi<span class="text-blue-600">.est1921</span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    Официальный магазин молодежной одежды. Стиль, вдохновленный историей.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-white hover:text-black transition duration-300">📷</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-blue-500 hover:text-white transition duration-300">✈️</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-[#ff0050] hover:text-white transition duration-300">🎵</a>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-lg mb-6">Магазин</h3>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">Каталог</a></li>
                    
                    <li><a href="{{ url('/') }}#new-arrivals" class="hover:text-white transition">Новинки</a></li>
                    
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">Распродажа</a></li>
                    
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">Аксессуары</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-lg mb-6">Покупателям</h3>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('page.delivery') }}" class="hover:text-white transition">Доставка и оплата</a></li>
                    <li><a href="{{ route('page.returns') }}" class="hover:text-white transition">Возврат товара</a></li>
                    <li><a href="{{ route('page.size-guide') }}" class="hover:text-white transition">Таблица размеров</a></li>
                    <li><a href="{{ route('page.contacts') }}" class="hover:text-white transition">Контакты</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Vernyi.est1921. Все права защищены.</p>
            <div class="flex gap-6">
                <span>Kaspi QR</span>
                <span>Visa / MasterCard</span>
            </div>
        </div>
    </div>
</footer>