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

        <!-- Навигационное меню -->
        <nav class="w-full flex justify-center mt-4 gap-4 mb-8">
            <a href="{{ route('profile') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-700 dark:hover:text-white transition">Мои работы</a>
            <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 transition">Коллекции</a>
            <a href="{{ route('profile.favorites') }}" class="px-4 py-2 rounded-lg font-medium bg-red-700 text-white transition">Понравившееся</a>
            <a href="{{ route('profile.about') }}" class="px-4 py-2 rounded-lg font-medium
                    {{ request()->routeIs('profile.about') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white' }}
                    transition">Обо мне
            </a>
        </nav>

        <h1 class="text-2xl font-bold mb-6">Понравившиеся работы</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($works as $work)
                <div class="bg-[#222326] rounded-xl shadow-lg overflow-hidden flex flex-col group transition hover:-translate-y-1 hover:shadow-xl">
                    @if($work->type == 'image')
                        <img src="{{ asset('storage/' . $work->file) }}" alt="work"
                             class="object-cover w-full h-48 rounded-t-xl group-hover:scale-105 transition" />
                    @else
                        <video src="{{ asset('storage/' . $work->file) }}" class="object-cover w-full h-48 rounded-t-xl" controls></video>
                    @endif
                    <div class="px-4 py-3 flex flex-col gap-2 flex-1">
                        <div class="flex items-center gap-2">
                            <img src="{{ $work->user->avatar ?? 'https://placehold.co/24x24/png' }}"
                                 class="w-6 h-6 rounded-full" alt="avatar">
                            <span class="text-sm font-medium text-gray-200">{{ $work->user->login ?? 'Без имени' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400 mt-2">
                            <span>{{ $work->likes->count() }}</span>
                            <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-gray-500 text-center py-8">Понравившихся работ пока нет</div>
            @endforelse
        </div>
    </div>
@endsection
