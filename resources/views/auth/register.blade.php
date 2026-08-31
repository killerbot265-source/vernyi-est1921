<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Vernyi.est1921</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        
        <div class="bg-gray-900 p-8 text-center">
            <a href="/" class="text-2xl font-bold text-white tracking-wider">
                Vernyi<span class="text-blue-500">.est1921</span>
            </a>
            <p class="text-gray-400 text-sm mt-2">Создай аккаунт и присоединяйся к культуре.</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Ваше Имя</label>
                    <input type="text" name="name" required autofocus 
                           class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="Иван Иванов" value="{{ old('name') }}">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Email адрес</label>
                    <input type="email" name="email" required 
                           class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="name@example.com" value="{{ old('email') }}">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Пароль</label>
                    <input type="password" name="password" required 
                           class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Повторите пароль</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-md transform hover:-translate-y-0.5">
                    Зарегистрироваться
                </button>

                <div class="text-center text-sm text-gray-500 mt-4">
                    Уже есть аккаунт? 
                    <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Войти</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>