<div class="w-full p-6">
                <!-- Навигационное меню для Дизайнера -->
                <nav class="w-full flex justify-center gap-4">
                    <a href="{{ route('profile') }}"
                       class="px-4 py-2 font-medium
                    {{ request()->routeIs('profile') ? 'border-b-2 border-[#D90751] text-[#D90751]' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-700 dark:hover:text-white' }}
                    transition"><i class="fa-solid fa-bag-shopping w-4 me-1"></i> Мои покупки
                    </a>
                    <a href="#" class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200 dark:hover:text-[#D90751] transition"><i class="fa-solid fa-box w-4 me-1"></i> Мои товары</a>
                    <a href="#" class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200 dark:hover:text-[#D90751] transition"><i class="fa-solid fa-star-half-stroke w-4 me-1"></i> Отзывы</a>
{{--                    <a href="{{ route('profile.favorites') }}"--}}
{{--                       class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white transition">--}}
{{--                        Понравившееся--}}
{{--                    </a>--}}
                    <a href="{{ route('profile.about') }}" class="px-4 py-2 rounded-lg font-medium
                    {{ request()->routeIs('profile.about') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 dark:hover:text-[#D90751]' }}
                    transition"><i class="fa-solid fa-user me-1"></i> Обо мне
                    </a>
                </nav>
            </div>