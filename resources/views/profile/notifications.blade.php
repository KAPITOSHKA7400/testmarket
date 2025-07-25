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
    <h1 class="text-2xl font-bold mb-6">Уведомления</h1>
    <div class="text-gray-500 dark:text-gray-400">
        Тут будет раздел настроек безопасности профиля.
    </div>
</div>
@endsection
