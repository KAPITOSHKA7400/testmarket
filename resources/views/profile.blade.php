@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-0 bg-white dark:bg-[#151920] rounded-xl overflow-hidden shadow flex flex-col items-center">
        <!-- Верхний блок баннер профиля -->
        @if(Auth::user()->user_banner)
            <div class="mb-4 relative">
                <img src="{{ asset('storage/' . Auth::user()->user_banner) }}"
                     alt="Баннер профиля"
                     class="w-full max-h-64 object-cover shadow">
                <div class="mb-3 absolute top-2 right-2">
                    <span class="uppercase px-2 py-1 rounded
                        @if(Auth::user()->role == 'admin') bg-red-100 text-red-600
                        @elseif(Auth::user()->role == 'moder') bg-blue-100 text-blue-600
                        @elseif(Auth::user()->role == 'user') bg-purple-100 text-purple-600
                        @elseif(Auth::user()->role == 'banned') bg-yellow-100 text-yellow-600
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ Auth::user()->role }}</span>
                </div>
            </div>
        @endif

        @auth
            <!-- Верхний блок профиля и меню -->
            <div class="flex flex-col items-center -mt-24 z-10">
                <img src="{{ Auth::user()->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                     alt="Аватар"
                     class="w-[150px] h-[150px] rounded-full object-cover border-4 border-gray-300 dark:border-[#151920] shadow mb-3">
                <div class="flex gap-3">
                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        {{ Auth::user()->login }}
                    </div>
                    <!-- Меню с тремя точками -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                                class="p-2 px-4 rounded-xl hover:bg-gray-700 transition bg-gray-800 text-white"
                                title="Открыть меню">
                            <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                        </button>

                        <!-- Выпадающее меню -->
                        <div x-show="open"
                             x-transition
                             class="absolute overflow-hidden right-0 mt-2 w-40 bg-gray-800 text-white rounded-xl shadow-lg border border-gray-700 z-50">

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 hover:bg-gray-700 text-sm">
                                <i class="fa-solid fa-pen mr-2 w-4"></i> Редактировать
                            </a>

                            {{-- Тут можно будет добавить другие действия в будущем --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center gap-8 text-gray-800 dark:text-white rounded-xl py-4 px-6">
                <!-- Продаж -->
                <div class="flex flex-col items-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">0</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Продаж</div>
                </div>

                <!-- Вертикальная линия -->
                <div class="w-px h-8 bg-gray-300 dark:bg-gray-700"></div>

                <!-- Покупок -->
                <div class="flex flex-col items-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">0</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Покупок</div>
                </div>
            </div>

            @include('profile._main_nav')

        @endif
    </div>
@endsection
