<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .text-outline { -webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-gray-900 bg-white">

    @include('partials.header')

    <main class="flex-grow pt-16">

        <section class="relative bg-black text-white py-24 md:py-32 overflow-hidden">
            <div class="absolute inset-0 opacity-40">
                <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <span class="text-blue-500 font-bold uppercase tracking-widest text-xs mb-4 block">Concept Store & Local Brand</span>
                <h1 class="text-4xl md:text-7xl font-extrabold leading-tight mb-6">
                    Больше, чем <br>
                    просто бренд.
                </h1>
                <p class="text-gray-300 text-lg max-w-xl leading-relaxed">
                    Vernyi.est1921 — это мультибрендовое пространство в Алматы. Мы создаем собственную уличную одежду и объединяем лучшие дропы от партнеров в одном месте.
                </p>
            </div>
        </section>

        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    <div class="relative group">
                        <div class="h-80 rounded-2xl overflow-hidden mb-6 relative">
                            <img src="https://images.unsplash.com/photo-1512353087810-25dfcd100962?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                            <div class="absolute bottom-4 left-4 bg-white text-black px-3 py-1 text-xs font-bold rounded uppercase">Own Production</div>
                        </div>
                        <h3 class="text-2xl font-extrabold mb-3">Линейка Vernyi™</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Сердце нашего проекта. Мы создали собственную базу, которая станет фундаментом твоего гардероба. Худи, футболки и штаны с выверенным кроем и идеальной посадкой. Собственное производство позволяет нам контролировать каждый этап: от выбора премиального хлопка до финального шва.          
                        </p>
                    </div>

                    <div class="relative group">
                        <div class="h-80 rounded-2xl overflow-hidden mb-6 relative">
                            <img src="https://images.unsplash.com/photo-1576995853123-5a10305d93c0?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                            <div class="absolute bottom-4 left-4 bg-black text-white px-3 py-1 text-xs font-bold rounded uppercase">Curated Selection</div>
                        </div>
                        <h3 class="text-2xl font-extrabold mb-3">Селекция брендов</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Мы не ограничиваемся собой. Мы ищем и привозим другие крутые бренды, которые близки нам по духу. В нашем каталоге вы найдете редкие айтемы, аксессуары и лимитированные коллекции от партнеров. Только оригинал, только стиль.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-20 bg-gray-50 border-t border-gray-100">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" class="w-12 h-12 mx-auto mb-6 opacity-20"> <h2 class="text-3xl font-extrabold mb-6">Почему "Vernyi"?</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    <strong>Vernyi (Верный)</strong> — это историческое название Алматы. 
                    <br>
                    <strong>Est. 1921</strong> — год переименования, символ начала новой эпохи.
                </p>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-left md:text-center">
                    <p class="text-gray-500 italic">
                        "Мы назвали магазин так, чтобы подчеркнуть связь с родным городом. Мы — локальный проект, который вырос из любви к улицам Алматы. Мы хотим, чтобы наши клиенты носили качественную одежду, будь то нашего производства или лучших мировых брендов."
                    </p>
                    <div class="mt-4 font-bold text-gray-900">— Команда Vernyi.est1921</div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-black text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-extrabold text-blue-500 mb-1">2021</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Год основания</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-blue-500 mb-1">10+</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Брендов в каталоге</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-blue-500 mb-1">100%</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Оригинальный товар</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-blue-500 mb-1">KZ</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Доставка по стране</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-extrabold mb-6">Готов обновить гардероб?</h2>
                <p class="text-gray-500 mb-8">Зацени нашу новую коллекцию и поступления от других брендов.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('shop.index') }}" class="px-8 py-4 bg-black text-white font-bold rounded-full hover:bg-gray-800 transition shadow-lg">
                        Перейти в каталог
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'xudi']) }}" class="px-8 py-4 bg-white text-black border border-gray-200 font-bold rounded-full hover:bg-gray-50 transition">
                        Смотреть Худи Vernyi
                    </a>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')
</body>
</html>