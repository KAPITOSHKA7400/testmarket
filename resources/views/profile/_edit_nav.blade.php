<nav class="flex mb-8 gap-2 border-b border-gray-200 dark:border-gray-800">
    <a href="{{ route('profile.edit') }}"
       class="px-4 py-2 font-semibold
       {{ request()->routeIs('profile.edit') ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600 dark:text-gray-300' }}">
        Ред. Профиль
    </a>
    <a href="{{ route('profile.security') }}"
       class="px-4 py-2 font-semibold
       {{ request()->routeIs('profile.security') ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600 dark:text-gray-300' }}">
        Безопасность
    </a>
    <a href="{{ route('profile.social') }}"
       class="px-4 py-2 font-semibold
       {{ request()->routeIs('profile.social') ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600 dark:text-gray-300' }}">
        Соц. сети
    </a>
    <a href="{{ route('profile.notifications') }}"
       class="px-4 py-2 font-semibold
       {{ request()->routeIs('profile.notifications') ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600 dark:text-gray-300' }}">
        Уведомления
    </a>
    <a href="{{ route('profile.sessions') }}"
       class="px-4 py-2 font-semibold
       {{ request()->routeIs('profile.sessions') ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600 dark:text-gray-300' }}">
        Сессии
    </a>
</nav>
