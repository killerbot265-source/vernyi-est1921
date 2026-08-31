<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица размеров - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="flex flex-col min-h-screen text-gray-900 bg-white">

    @include('partials.header')

    <main class="flex-grow max-w-5xl mx-auto px-4 py-16 w-full">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Таблица размеров</h1>
        <p class="text-gray-500 mb-10">Наши вещи имеют крой <strong>Oversize</strong>. Если вы хотите более плотную посадку, берите на размер меньше.</p>
        
        <h3 class="text-xl font-bold text-gray-900 mb-4">Худи и Свитшоты</h3>
        <div class="overflow-x-auto mb-12 rounded-xl border border-gray-100 shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4">Размер</th>
                        <th class="px-6 py-4">Рост (см)</th>
                        <th class="px-6 py-4">Ширина (см)</th>
                        <th class="px-6 py-4">Длина (см)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4 font-bold">S</td>
                        <td class="px-6 py-4">160 - 170</td>
                        <td class="px-6 py-4">54</td>
                        <td class="px-6 py-4">68</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-bold">M</td>
                        <td class="px-6 py-4">170 - 178</td>
                        <td class="px-6 py-4">56</td>
                        <td class="px-6 py-4">70</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-bold">L</td>
                        <td class="px-6 py-4">178 - 185</td>
                        <td class="px-6 py-4">58</td>
                        <td class="px-6 py-4">72</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-bold">XL</td>
                        <td class="px-6 py-4">185 - 192</td>
                        <td class="px-6 py-4">60</td>
                        <td class="px-6 py-4">74</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-bold">2XL</td>
                        <td class="px-6 py-4">192+</td>
                        <td class="px-6 py-4">64</td>
                        <td class="px-6 py-4">76</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-blue-50 p-6 rounded-xl flex items-start gap-4">
            <div class="text-2xl">📏</div>
            <div>
                <h4 class="font-bold text-blue-900">Как измерить?</h4>
                <p class="text-sm text-blue-800 mt-1">Возьмите свою любимую худи, положите на ровную поверхность и измерьте ширину от подмышки до подмышки. Сравните с нашей таблицей.</p>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>