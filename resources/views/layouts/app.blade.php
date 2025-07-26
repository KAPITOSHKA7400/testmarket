<!DOCTYPE html>
<html  lang="ru" class="h-full scroll-smooth">
    <head>
        <script>
            // Определяем, нужно ли включить тёмную тему
            const saved = localStorage.getItem('darkMode');
            const enabled = saved === null ? true : saved === 'true';

            document.documentElement.classList.toggle('dark', enabled);
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Telsup</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body class="h-full bg-white text-gray-900 dark:bg-[#101318] dark:text-gray-100 transition-colors flex flex-col min-h-screen">

        <header class="bg-[#151920] text-white border-b border-gray-700 shadow-sm">
            <div x-data="{ openNav: false }"
                 class="container max-w-screen-xl mx-auto flex flex-wrap items-center justify-between px-4 py-4 gap-2">

                <!-- Логотип -->
                <a href="/" class="text-2xl font-black tracking-widest">
                    XYLINET ?!
                </a>

                <!-- Бургер-кнопка -->
                <button @click="openNav = !openNav" class="md:hidden text-white">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Навигация -->
                <nav :class="openNav ? 'flex flex-col w-full mt-3 gap-2 text-sm' : 'hidden md:flex md:items-center md:gap-6 text-sm md:w-auto'">
                    <a href="/" class="hover:text-orange-400">Главная</a>
                    <a href="/catalog" class="hover:text-orange-400">Каталог товаров</a>
                    <a href="/help" class="hover:text-orange-400">Помощь</a>
                </nav>

                <!-- Иконки и профиль -->
                <div class="flex items-center gap-2 md:mt-0">
                    <!-- Темная тема -->
                    <button
                        x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" @click="darkMode = !darkMode;
                            localStorage.setItem('darkMode', darkMode);
                            document.documentElement.classList.toggle('dark', darkMode);"
                        class="h-9 w-9 p-2.5 flex items-center justify-center bg-gray-800 rounded-xl hover:bg-gray-700 transition text-white"
                        title="Сменить тему">
                        <i :class="darkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon'"></i>
                    </button>

                    @auth
                        <!-- Уведомления -->
                        <button class="h-9 w-9 p-2.5 flex items-center justify-center bg-gray-800 rounded-xl hover:bg-gray-700 transition text-white">
                            <i class="fa-regular fa-bell text-base"></i>
                        </button>

                        <!-- Баланс -->
                        <div class="h-9 px-2.5 flex items-center gap-1 text-sm bg-gray-800 rounded-xl text-white">
                            <i class="fa-solid fa-wallet text-base"></i> 0 ₽
                        </div>

                        <!-- Профиль -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                    class="h-9 px-2.5 flex items-center gap-2 bg-gray-800 rounded-xl text-white hover:bg-gray-700 transition">
                                <img src="{{ Auth::user()->avatar ? asset('' . Auth::user()->avatar) : 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                                     alt="avatar" class="w-5 h-5 rounded-full object-cover border border-gray-700">
                                <span class="font-semibold text-sm leading-none">{{ Auth::user()->login }}</span>
                                <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                            </button>

                            <!-- Выпадающее меню -->
                            <div x-show="open" x-transition
                                 class="absolute overflow-hidden right-0 mt-2 w-56 bg-gray-800 text-white rounded-xl shadow-xl border border-gray-700 z-50">

                                <!-- ССЫЛКА НА ПРОФИЛЬ -->
                                <a href="/profile" class="flex items-center gap-3 px-4 py-3 border-b border-gray-700 hover:bg-gray-700 transition">
                                    <img src="{{ Auth::user()->avatar ? asset('' . Auth::user()->avatar) : 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                                         class="w-10 h-10 rounded-full border border-gray-700 object-cover">
                                    <div class="text-sm">
                                        <div class="font-semibold">{{ Auth::user()->login }}</div>
                                        <div class="text-xs text-gray-400">Мой профиль</div>
                                    </div>
                                </a>

                                <!-- Остальные ссылки -->
                                <a href="/chat" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-700 text-sm">
                                    <i class="fa-solid fa-comments w-4"></i> Чат
                                </a>
                                <a href="/profile/orders" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-700 text-sm">
                                    <i class="fa-solid fa-bag-shopping w-4"></i> Мои покупки
                                </a>
                                <a href="/profile/lots" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-700 text-sm">
                                    <i class="fa-solid fa-box w-4"></i> Мои товары
                                </a>
                                <a href="/settings" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-700 text-sm">
                                    <i class="fa-solid fa-gear w-4"></i> Настройки
                                </a>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-gray-700 text-red-400 text-sm">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Выход
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Для гостей -->
                        <a href="{{ route('login') }}"
                           class="text-sm bg-gray-800 hover:bg-gray-700 py-1.5 px-4 rounded-xl text-white transition">Вход</a>
                        <a href="{{ route('register') }}"
                           class="text-sm bg-orange-500 hover:bg-orange-600 text-white py-1.5 px-4 rounded-xl transition">Регистрация</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="container max-w-screen-xl mx-auto px-4 pt-4 mb-4">
            @yield('content')
        </main>

        <footer class="bg-white/95 dark:bg-gray-950/95 text-gray-400 dark:text-gray-500 text-center border-t border-gray-200 dark:border-gray-800 py-3 mt-auto">
            &copy; {{ date('Y') }} Telsup. Все права защищены.
        </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-work-id]').forEach(function(card) {
                card.addEventListener('click', function() {
                    const workId = this.getAttribute('data-work-id');
                    fetch(`/works/${workId}/view`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const modal = document.getElementById('workDetailModal');
                    if (modal) {
                        modal.classList.add('open');
                    }
                });
            });
        });
    </script>

    </body>
</html>
