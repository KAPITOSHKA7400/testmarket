@extends('layouts.app')

@section('content')
    <div class="max-w-md w-full mx-auto mt-12 bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-gray-100">Регистрация</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register" autocomplete="off" class="space-y-5">
            @csrf

            <div>
                <label for="login" class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300">Логин</label>
                <input id="login" name="login" type="text" required
                       value="{{ old('login') }}"
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300">Email</label>
                <input id="email" name="email" type="email" required
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300">Пароль</label>
                <input id="password" name="password" type="password" required
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300">Повторите пароль</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                        class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow transition">
                    Зарегистрироваться
                </button>
                <a href="/login" class="text-orange-500 hover:underline text-sm">Уже есть аккаунт?</a>
            </div>
        </form>
    </div>
@endsection
