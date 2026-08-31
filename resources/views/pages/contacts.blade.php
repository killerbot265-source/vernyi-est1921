<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex flex-col min-h-screen text-gray-900 bg-white">

    @include('partials.header')

    <main class="flex-grow max-w-7xl mx-auto px-4 py-16 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-8">Свяжитесь с нами</h1>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Есть вопросы по размеру, доставке или сотрудничеству? Мы всегда на связи в рабочее время.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xl">📍</div>
                        <div>
                            <h4 class="font-bold">Адрес шоурума</h4>
                            <p class="text-gray-500 text-sm">г. Алматы, ул. Кабанбай батыра, 123 (Пример)</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xl">📞</div>
                        <div>
                            <h4 class="font-bold">Телефон / WhatsApp</h4>
                            <p class="text-gray-500 text-sm">+7 (700) 123-45-67</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xl">📧</div>
                        <div>
                            <h4 class="font-bold">Email</h4>
                            <p class="text-gray-500 text-sm">hello@vernyi.kz</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xl">⏰</div>
                        <div>
                            <h4 class="font-bold">Режим работы</h4>
                            <p class="text-gray-500 text-sm">Ежедневно: 10:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-96 bg-gray-100 rounded-2xl overflow-hidden relative">
                <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-200">
                    <span>Карта Алматы</span>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>