@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 bg-white dark:bg-gray-900 p-8 rounded-xl shadow">
        <!-- Верхний блок профиля и меню -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ Auth::user()->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                 alt="Аватар"
                 class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ Auth::user()->login }}
            </div>
        </div>

        @include('profile._edit_nav')

        {{-- Заголовок --}}
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Социальные профили</h2>

        {{-- Форма --}}
        <form method="POST" action="{{ route('social.update') }}" class="space-y-4">
            @csrf

            @php
                $socials = [
                    ['label' => 'Telegram', 'icon' => 'fab fa-telegram', 'field' => 'telegram'],
                    ['label' => 'ВКонтакте', 'icon' => 'fab fa-vk', 'field' => 'vk'],
                    ['label' => 'Twitter (x.com)', 'icon' => 'fab fa-x-twitter', 'field' => 'xcom'],
                    ['label' => 'GitHub', 'icon' => 'fab fa-github', 'field' => 'github'],
                    ['label' => 'CodePen', 'icon' => 'fab fa-codepen', 'field' => 'codepen'],
                    ['label' => 'Behance', 'icon' => 'fab fa-behance', 'field' => 'behance'],
                    ['label' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'field' => 'linkedin'],
                    ['label' => 'Vimeo', 'icon' => 'fab fa-vimeo', 'field' => 'vimeo'],
                    ['label' => 'YouTube', 'icon' => 'fab fa-youtube', 'field' => 'youtube'],
                ];
            @endphp

            @foreach($socials as $social)
                <div class="flex items-center">
                    <i class="{{ $social['icon'] }} text-xl text-gray-600 dark:text-gray-400 w-8"></i>
                    <input type="url"
                           name="{{ $social['field'] }}"
                           placeholder="Ссылка на {{ $social['label'] }}"
                           value="{{ old($social['field'], Auth::user()->{$social['field']}) }}"
                           class="flex-1 px-4 py-2 rounded border bg-white border-gray-300 text-gray-800 placeholder-gray-500
               dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>
            @endforeach

            <div class="text-right pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition-colors">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
@endsection
