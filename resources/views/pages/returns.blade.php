<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Возврат товара - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex flex-col min-h-screen text-gray-900 bg-white">

    @include('partials.header')

    <main class="flex-grow max-w-4xl mx-auto px-4 py-16 w-full">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-8">Возврат и обмен</h1>
        
        <div class="prose prose-lg text-gray-600 max-w-none">
            <p>Если товар вам не подошел, вы можете вернуть или обменять его в течение <strong>14 дней</strong> с момента получения заказа, согласно законодательству РК.</p>
            
            <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">Условия возврата</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Вещь не была в употреблении (нет следов носки, стирки, запахов).</li>
                <li>Сохранены все бирки, ярлыки и оригинальная упаковка.</li>
                <li>Имеется чек или подтверждение покупки.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">Как оформить возврат?</h3>
            <p>
                Напишите нам в <a href="#" class="text-blue-600 font-bold hover:underline">WhatsApp</a> или Instagram. 
                Менеджер подскажет, куда отправить посылку (CDEK / Яндекс).
            </p>
            
            <div class="bg-gray-50 p-6 rounded-xl mt-8 border border-gray-100">
                <p class="text-sm"><strong>Важно:</strong> Расходы на доставку при возврате (если нет брака) оплачивает покупатель.</p>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>