@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 bg-white dark:bg-gray-900 p-8 rounded-xl shadow flex flex-col items-center">

        <!-- Верхний блок профиля и меню -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ Auth::user()->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                 alt="Аватар"
                 class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ Auth::user()->login }}
            </div>
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-full font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16.862 3.487a2.062 2.062 0 1 1 2.92 2.92l-12.293 12.293-3.094.344.344-3.094L16.862 3.487z"/>
                </svg>
                Редактировать профиль
            </a>
        </div>

        <!-- Навигационное меню для Дизайнера -->
        <nav class="w-full flex justify-center mt-4 gap-4 mb-8">
            <a href="{{ route('profile') }}"
               class="px-4 py-2 rounded-lg font-medium
                    {{ request()->routeIs('profile') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-700 dark:hover:text-white' }}
                    transition">Мои работы
            </a>
            <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 transition">Коллекции</a>
            <a href="{{ route('profile.favorites') }}"
               class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white transition">
                Понравившееся
            </a>
            <a href="{{ route('profile.about') }}" class="px-4 py-2 rounded-lg font-medium
                    {{ request()->routeIs('profile.about') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white' }}
                    transition">Обо мне
            </a>
        </nav>

        <!-- Информация "Обо мне" -->
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8 mb-4">Обо мне</h1>

        <div class="p-6 rounded-lg text-gray-800 dark:text-gray-100 space-y-4 w-full max-w-2xl">

            @if(Auth::user()->website)
                <div class="flex items-start gap-2">
                    <i class="fas fa-globe text-gray-600 dark:text-gray-400 mt-1"></i>
                    <p><strong>Веб-сайт:</strong>
                        <a href="{{ Auth::user()->website }}" target="_blank"
                           class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ Auth::user()->website }}
                        </a>
                    </p>
                </div>
            @endif

            @if(Auth::user()->country)
                <div class="flex items-start gap-2">
                    <i class="fas fa-flag text-gray-600 dark:text-gray-400 mt-1"></i>
                    <p><strong>Страна:</strong> {{ Auth::user()->country }}</p>
                </div>
            @endif

            @if(Auth::user()->city)
                <div class="flex items-start gap-2">
                    <i class="fas fa-city text-gray-600 dark:text-gray-400 mt-1"></i>
                    <p><strong>Город:</strong> {{ Auth::user()->city }}</p>
                </div>
            @endif

            @if(Auth::user()->about)
                <div class="flex items-start gap-2">
                    <i class="fas fa-user text-gray-600 dark:text-gray-400 mt-1"></i>
                    <div>
                        <strong>О себе:</strong>
                        <p class="mt-1 whitespace-pre-line">{{ Auth::user()->about }}</p>
                    </div>
                </div>
            @endif

            <div>
                <strong>Социальные сети:</strong>
                <ul class="mt-2 space-y-1">
                    @php
                        $links = [
                            ['field' => 'telegram', 'label' => 'Telegram', 'icon' => 'fab fa-telegram'],
                            ['field' => 'vk', 'label' => 'ВКонтакте', 'icon' => 'fab fa-vk'],
                            ['field' => 'xcom', 'label' => 'Twitter (x.com)', 'icon' => 'fab fa-x-twitter'],
                            ['field' => 'github', 'label' => 'GitHub', 'icon' => 'fab fa-github'],
                            ['field' => 'codepen', 'label' => 'CodePen', 'icon' => 'fab fa-codepen'],
                            ['field' => 'behance', 'label' => 'Behance', 'icon' => 'fab fa-behance'],
                            ['field' => 'linkedin', 'label' => 'LinkedIn', 'icon' => 'fab fa-linkedin'],
                            ['field' => 'vimeo', 'label' => 'Vimeo', 'icon' => 'fab fa-vimeo'],
                            ['field' => 'youtube', 'label' => 'YouTube', 'icon' => 'fab fa-youtube'],
                        ];
                    @endphp

                    @foreach($links as $link)
                        @if(Auth::user()->{$link['field']})
                            <li class="flex items-center gap-2">
                                <i class="{{ $link['icon'] }} text-lg text-gray-600 dark:text-gray-400 w-5"></i>
                                <a href="{{ Auth::user()->{$link['field']} }}" target="_blank"
                                   class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
