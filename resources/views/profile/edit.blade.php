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

        <!-- Верхнее меню -->
        @include('profile._edit_nav')


        <h1 class="text-2xl font-bold mb-6">Редактировать профиль</h1>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Аватарка -->
            <div class="mb-4">
                <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Аватар</label>
                <div class="flex items-center gap-4">
                    <img src="{{ Auth::user()->avatar ?? 'https://via.placeholder.com/80x80?text=Avatar' }}" alt="Avatar"
                         class="w-20 h-20 rounded-full object-cover border border-gray-300 dark:border-gray-700">
                    <div class="flex flex-col gap-2">
                        <input type="file" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" accept="image/*">
                        @if(Auth::user()->avatar)
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" name="remove_avatar" value="1" class="form-checkbox text-red-600">
                                <span class="ml-2 text-red-600 text-sm">Удалить аватарку</span>
                            </label>
                        @endif
                    </div>
                </div>
                @error('avatar')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Логин (только для чтения) -->
            <div>
                <label for="login" class="block mb-1 font-medium">Логин</label>
                <input id="login" name="login" type="text"
                       value="{{ old('login', Auth::user()->login) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700" readonly>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 font-medium">Электронная почта</label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', Auth::user()->email) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700" readonly>
            </div>

            <!-- Телефон -->
            <div>
                <label for="phone" class="block mb-1 font-medium">Номер телефона</label>
                <input id="phone" name="phone" type="text"
                       value="{{ old('phone', Auth::user()->phone) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700">
            </div>

            <!-- Веб-сайт -->
            <div>
                <label for="website" class="block mb-1 font-medium">Веб-сайт</label>
                <input id="website" name="website" type="url"
                       value="{{ old('website', Auth::user()->website) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700">
            </div>

            <!-- Страна -->
            <div>
                <label for="country" class="block mb-1 font-medium">Страна</label>
                <input id="country" name="country" type="text"
                       value="{{ old('country', Auth::user()->country) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700">
            </div>

            <!-- Город -->
            <div>
                <label for="city" class="block mb-1 font-medium">Город</label>
                <input id="city" name="city" type="text"
                       value="{{ old('city', Auth::user()->city) }}"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700">
            </div>

            <!-- О себе -->
            <div>
                <label for="about" class="block mb-1 font-medium">О себе</label>
                <textarea id="about" name="about" rows="4"
                          class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700">{{ old('about', Auth::user()->about) }}</textarea>
            </div>

            <button type="submit"
                    class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow transition">
                Сохранить изменения
            </button>
        </form>
    </div>
@endsection
