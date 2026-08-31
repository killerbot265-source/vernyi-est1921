<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доставка и оплата - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex flex-col min-h-screen text-gray-900 bg-white">

    @include('partials.header')

    <main class="flex-grow max-w-4xl mx-auto px-4 py-16 w-full">
        <h1 class="text-3xl font-bold mb-8">Доставка и оплата</h1>
        
        <div class="prose max-w-none text-gray-600 space-y-6">
            <p>Мы осуществляем доставку по всему Казахстану.</p>
            
            <h3 class="text-xl font-bold text-gray-900">По Алматы</h3>
            <ul class="list-disc pl-5">
                <li>Яндекс.Доставка (по тарифам такси)</li>
                <li>Самовывоз из нашего шоурума (бесплатно)</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-900">По Казахстану</h3>
            <p>Отправляем через CDEK или KazPost. Срок доставки: 2-5 рабочих дней.</p>

            <h3 class="text-xl font-bold text-gray-900">Оплата</h3>
            <p>Мы принимаем оплату через Kaspi QR, Kaspi Red или банковской картой Visa/MasterCard.</p>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>