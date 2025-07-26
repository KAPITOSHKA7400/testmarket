@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 bg-white dark:bg-gray-900 p-8 rounded-xl shadow flex flex-col items-center">

        <!-- Верхний блок профиля -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ $user->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                 alt="Аватар"
                 class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ $user->login }}
            </div>
            <div class="mb-3">
                <span class="uppercase px-2 py-1 rounded
                @if($user->role == 'admin') bg-red-100 text-red-600
                @elseif($user->role == 'moder') bg-blue-100 text-blue-600
                @elseif($user->role == 'user') bg-purple-100 text-purple-600
                @elseif($user->role == 'banned') bg-yellow-100 text-yellow-600
                @else bg-gray-100 text-gray-600
                @endif">

                    @if($user->role == 'admin') Администратор
                    @elseif($user->role == 'moder') Модератор
                    @elseif($user->role == 'user') Разработчик
                    @elseif($user->role == 'banned') Партнёр
                    @else {{ $user->role }}
                    @endif
            </span>
            </div>

        </div>
    </div>
@endsection


{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container mx-auto px-4 py-8">--}}
{{--        --}}{{-- ВЕРХНИЙ БЛОК ПРОФИЛЯ --}}
{{--        <div class="flex flex-col md:flex-row items-start md:items-center bg-gray-900 dark:bg-[#151920] rounded-xl shadow px-6 py-6 gap-6 mb-5">--}}
{{--            --}}{{-- Аватар --}}
{{--            <div>--}}
{{--                <img src="{{ $user->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"--}}
{{--                     alt="Аватар"--}}
{{--                     class="w-24 h-24 rounded-full object-cover border-4 border-gray-300 dark:border-[#151920] shadow">--}}
{{--            </div>--}}
{{--            --}}{{-- Основная инфа --}}
{{--            <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-y-1 gap-x-8">--}}
{{--                <div>--}}
{{--                    <div class="flex items-center gap-2">--}}
{{--                        <span class="text-xl font-bold text-white">{{ $user->login }}</span>--}}
{{--                        --}}{{-- Статус онлайн (примерно) --}}
{{--                        <span class="ml-2 text-green-500 text-xs font-semibold flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Онлайн</span>--}}
{{--                    </div>--}}
{{--                    <div class="uppercase text-xs mt-1 text-gray-400">Титул</div>--}}
{{--                    <div class="font-semibold text-green-400 text-sm">Проверенный</div>--}}
{{--                    <div class="uppercase text-xs mt-4 text-gray-400">Дата регистрации</div>--}}
{{--                    <div class="text-gray-200 text-sm">{{ $user->created_at->format('d.m.Y, H:i') }}</div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="uppercase text-xs text-gray-400">Куплено товаров</div>--}}
{{--                    <div class="text-lg font-bold text-white">{{ $user->bought_count ?? 0 }}</div>--}}
{{--                    <div class="uppercase text-xs mt-4 text-gray-400">Отзывы</div>--}}
{{--                    <div class="text-lg font-bold text-white">{{ $user->feedbacks_count ?? 0 }}</div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="uppercase text-xs text-gray-400">Продано товаров</div>--}}
{{--                    <div class="text-lg font-bold text-white">{{ $user->sold_count ?? 0 }}</div>--}}
{{--                    <div class="uppercase text-xs mt-4 text-gray-400">Рейтинг продавца</div>--}}
{{--                    <div class="text-3xl font-bold text-white">{{ $user->rating ?? '4.9' }} <span class="text-xl text-gray-400">из 5</span></div>--}}
{{--                </div>--}}
{{--                <div class="flex flex-col items-end md:items-end gap-2 justify-between">--}}
{{--                    <div class="flex gap-2">--}}
{{--                        <button class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2">--}}
{{--                            <i class="fa-regular fa-comments"></i> Написать--}}
{{--                        </button>--}}
{{--                        <button class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2">--}}
{{--                            <i class="fa-regular fa-star"></i> Подписаться--}}
{{--                        </button>--}}
{{--                        <button class="bg-gray-800 hover:bg-gray-700 text-white px-2 py-2 rounded-lg flex items-center justify-center" title="Меню">--}}
{{--                            <i class="fa-solid fa-ellipsis"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- ОПИСАНИЕ ПРОФИЛЯ --}}
{{--        <div class="bg-gray-900 dark:bg-[#151920] rounded-xl px-6 py-4 mb-5 text-gray-200 shadow">--}}
{{--            <div>--}}
{{--                {{ $user->about ?? 'Пользователь ещё не заполнил описание.' }}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- ФИЛЬТРЫ И СОРТИРОВКА --}}
{{--        <div class="flex flex-col md:flex-row gap-2 md:gap-4 mb-5">--}}
{{--            <div class="flex gap-2">--}}
{{--                <button class="px-4 py-2 bg-gray-800 text-white rounded-lg font-medium hover:bg-gray-700">Активные лоты</button>--}}
{{--                <button class="px-4 py-2 bg-gray-800 text-gray-400 rounded-lg font-medium cursor-not-allowed" disabled>Отзывы</button>--}}
{{--            </div>--}}
{{--            <div class="flex-1 flex flex-wrap gap-2 md:gap-4 justify-end">--}}
{{--                <select class="bg-gray-800 text-white rounded-lg px-3 py-2 border-none w-40">--}}
{{--                    <option>Статус</option>--}}
{{--                </select>--}}
{{--                <select class="bg-gray-800 text-white rounded-lg px-3 py-2 border-none w-40">--}}
{{--                    <option>Игра</option>--}}
{{--                </select>--}}
{{--                <input type="text" class="bg-gray-800 text-white rounded-lg px-3 py-2 border-none w-56" placeholder="Уточнить поиск ...">--}}
{{--                <button class="px-4 py-2 bg-gray-700 text-white rounded-lg font-semibold">Найти</button>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- СОРТИРОВКА и ВИД --}}
{{--        <div class="flex items-center gap-2 mb-4">--}}
{{--            <button class="bg-gray-800 text-white rounded-lg p-2 flex items-center justify-center"><i class="fa-solid fa-list"></i></button>--}}
{{--            <button class="bg-gray-800 text-white rounded-lg p-2 flex items-center justify-center"><i class="fa-solid fa-table-cells-large"></i></button>--}}
{{--            <span class="ml-4 text-gray-300">Сортировать:</span>--}}
{{--            <button class="text-white font-semibold underline ml-1">по названию</button>--}}
{{--            <button class="text-gray-400 ml-1">по статусу</button>--}}
{{--            <button class="text-gray-400 ml-1">по цене</button>--}}
{{--            <button class="text-gray-400 ml-1">по дате</button>--}}
{{--        </div>--}}

{{--        --}}{{-- СЕТКА ЛОТОВ --}}
{{--        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">--}}
{{--            @forelse($lots as $lot)--}}
{{--                <div class="aspect-square rounded-xl bg-gray-800/80 flex flex-col items-center justify-center text-gray-500 text-lg shadow">--}}
{{--                    --}}{{-- Здесь превью лота, название, цена и т.п. --}}
{{--                    {{ $lot->title ?? 'Лот' }}--}}
{{--                </div>--}}
{{--            @empty--}}
{{--                @for($i=0; $i<8; $i++)--}}
{{--                    <div class="aspect-square rounded-xl bg-gray-800/80"></div>--}}
{{--                @endfor--}}
{{--            @endforelse--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
