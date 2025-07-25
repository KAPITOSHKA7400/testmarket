<!DOCTYPE html>
<html lang="ru" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Telsup</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="h-full bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors flex flex-col min-h-screen">

<header class="bg-white/95 dark:bg-gray-950/95 border-b border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="container mx-auto flex justify-between items-center py-4 px-4">
        <!-- Логотип -->
        <a href="/" class="text-2xl font-bold text-orange-500 tracking-tight">Yabber</a>
        <div class="flex items-center gap-2">
            <!-- Кнопка Dark Mode -->
            <button
                class="px-3 py-1 rounded-lg font-semibold border border-orange-400 text-orange-500 bg-transparent hover:bg-orange-100 dark:hover:bg-gray-800 transition"
                @click="darkMode = !darkMode"
                title="Переключить тему">🌙</button>

            @guest
                <a href="/login"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    Авторизация
                </a>
                <a href="/register"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition ml-2">
                    Регистрация
                </a>
            @endguest

            @auth
                <div class="relative group">
                    <button class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                        Профиль
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-800 z-50
                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150">
                        <a href="/profile" class="block px-4 py-2 hover:bg-orange-50 dark:hover:bg-gray-800 transition">Профиль</a>
                        <a href="/settings" class="block px-4 py-2 hover:bg-orange-50 dark:hover:bg-gray-800 transition">Настройки</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-orange-50 dark:hover:bg-gray-800 transition text-red-600">Выход</button>
                        </form>
                    </div>
                </div>

            @endauth
        </div>
    </div>
</header>

<main class="container mx-auto px-4 pt-4">
    @yield('content')
</main>

<footer class="bg-white/95 dark:bg-gray-950/95 text-gray-400 dark:text-gray-500 text-center border-t border-gray-200 dark:border-gray-800 py-3 mt-auto">
    &copy; {{ date('Y') }} Telsup. Все права защищены.
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Вешаем обработчик на все карточки работ
        document.querySelectorAll('[data-work-id]').forEach(function(card) {
            card.addEventListener('click', function() {
                const workId = this.getAttribute('data-work-id');

                // Учёт просмотра через fetch
                fetch(`/works/${workId}/view`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                // Логика показа модалки (замени на свою, если надо)
                const modal = document.getElementById('workDetailModal');
                if (modal) {
                    modal.classList.add('open');
                    // Тут можно заполнить модалку данными
                }
            });
        });
    });
</script>


</body>
</html>
