<div class="w-full border-b border-gray-200 dark:border-gray-700 mb-6">
    <nav class="flex flex-col md:flex-row justify-around gap-2 md:gap-4 p-4 text-sm font-medium">
        <a href="#"
           class="@if(request()->routeIs('admin.dashboard')) text-[#D90751] @else text-gray-700 dark:text-gray-300 @endif hover:text-[#D90751] transition">
            <i class="fa-solid fa-gauge me-1"></i> Дашборд
        </a>
        <a href="{{ route('admin.games') }}"
           class="@if(request()->routeIs('admin.games')) text-[#D90751] @else text-gray-700 dark:text-gray-300 @endif hover:text-[#D90751] transition">
            <i class="fa-solid fa-gamepad me-1"></i> Игры и категории
        </a>
        <a href="{{ route('admin.users') }}"
           class="@if(request()->routeIs('admin.users')) text-[#D90751] @else text-gray-700 dark:text-gray-300 @endif hover:text-[#D90751] transition">
            <i class="fa-solid fa-users me-1"></i> Пользователи
        </a>
        <a href="#"
           class="@if(request()->routeIs('admin.lots')) text-[#D90751] @else text-gray-700 dark:text-gray-300 @endif hover:text-[#D90751] transition">
            <i class="fa-solid fa-boxes-stacked me-1"></i> Лоты
        </a>
        <a href="#"
           class="@if(request()->routeIs('admin.reviews')) text-[#D90751] @else text-gray-700 dark:text-gray-300 @endif hover:text-[#D90751] transition">
            <i class="fa-solid fa-star me-1"></i> Отзывы
        </a>
    </nav>
</div>
