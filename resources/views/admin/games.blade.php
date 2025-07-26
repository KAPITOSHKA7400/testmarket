@extends('layouts.app')
@section('content')

    <div class="container mx-auto mt-0 bg-white dark:bg-[#151920] rounded-xl overflow-hidden shadow p-8">
        @include('profile._admin_nav')

        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Управление играми и категориями</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Форма создания Игры -->
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Создать игру</h3>
                <form action="{{ route('admin.games.store') }}" method="POST">
                    @csrf
                    <input type="text" name="title" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3"
                           placeholder="Название игры" required>
                    <button class="w-full py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                        Создать игру
                    </button>
                </form>
            </div>

            <!-- Форма создания Типа товаров -->
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Создать тип товаров</h3>
                <form action="{{ route('admin.product_types.store') }}" method="POST">
                    @csrf
                    <select name="game_id" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3" required>
                        <option value="">Выберите игру</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="type_name" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3"
                           placeholder="Название типа (например: Валюта, Аккаунт, Ключ и т.д.)" required>
                    <button class="w-full py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                        Создать тип
                    </button>
                </form>
            </div>

            <!-- Форма создания Сервера -->
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Создать сервер</h3>
                <form action="{{ route('admin.servers.store') }}" method="POST">
                    @csrf
                    <select name="game_id" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3" required>
                        <option value="">Выберите игру</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                        @endforeach
                    </select>
                    <select name="type_id" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3" required>
                        <option value="">Выберите тип товара</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type_name }} ({{ $type->game->title }})</option>
                        @endforeach
                    </select>
                    <input type="text" name="server_name" class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 mb-3"
                           placeholder="Название сервера" required>
                    <button class="w-full py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700 transition">
                        Создать сервер
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-12">
            <!-- Игры -->
            <div class="mb-10">
                <form method="get" class="mb-2 flex gap-2">
                    <input type="text" name="search_game" value="{{ request('search_game') }}"
                           placeholder="Поиск по играм"
                           class="px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 w-64">
                    <button class="px-4 py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700">Поиск</button>
                </form>
                <div class="overflow-x-auto rounded-xl shadow mb-10">
                    <table class="min-w-full table-fixed w-full divide-y divide-gray-700 bg-gray-900 rounded-xl">
                        <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wider bg-gray-800">
                            <th class="w-16 px-6 py-3">ID</th>
                            <th class="px-6 py-3 text-left">Название</th>
                            <th class="px-6 py-3 text-left">Дата создания</th>
                            <th class="w-40 px-6 py-3 text-center">Управление</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-sm">
                        @foreach($games as $game)
                            <tr>
                                <td class="w-16 px-6 py-3 text-[#D90751]">{{ $game->id }}</td>
                                <td class="px-6 py-3">{{ $game->title }}</td>
                                <td class="px-6 py-3">{{ $game->created_at->format('d.m.Y H:i') }}</td>
                                <td class="w-40 px-6 py-3 text-center">
                                    <a href="#" class="text-[#D90751] hover:underline">Редактировать</a>
                                    <span class="mx-1 text-gray-500">|</span>
                                    <a href="#" class="text-red-400 hover:underline">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $games->appends(request()->except('games_page'))->links() }}
                    </div>
                </div>

                <div class="mt-2">
                    {{ $games->appends(['search_game' => request('search_game')])->links() }}
                </div>
            </div>

            <!-- Типы товаров -->
            <div class="mb-10">
                <form method="get" class="mb-2 flex gap-2">
                    <input type="text" name="search_type" value="{{ request('search_type') }}"
                           placeholder="Поиск по типам товаров"
                           class="px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 w-64">
                    <button class="px-4 py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700">Поиск</button>
                </form>
                <div class="overflow-x-auto rounded-xl shadow mb-10">
                    <table class="min-w-full table-fixed w-full divide-y divide-gray-700 bg-gray-900 rounded-xl">
                        <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wider bg-gray-800">
                            <th class="w-16 px-6 py-3">ID</th>
                            <th class="px-6 py-3 text-left">Тип</th>
                            <th class="px-6 py-3 text-left">Игра</th>
                            <th class="px-6 py-3 text-left">Дата создания</th>
                            <th class="w-40 px-6 py-3 text-center">Управление</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-sm">
                        @foreach($types as $type)
                            <tr>
                                <td class="w-16 px-6 py-3 text-[#D90751]">{{ $type->id }}</td>
                                <td class="px-6 py-3">{{ $type->type_name }}</td>
                                <td class="px-6 py-3">{{ $type->game->title ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $type->created_at->format('d.m.Y H:i') }}</td>
                                <td class="w-40 px-6 py-3 text-center">
                                    <a href="#" class="text-[#D90751] hover:underline">Редактировать</a>
                                    <span class="mx-1 text-gray-500">|</span>
                                    <a href="#" class="text-red-400 hover:underline">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $types->appends(request()->except('types_page'))->links() }}
                    </div>
                </div>

                <div class="mt-2">
                    {{ $types->appends(['search_type' => request('search_type')])->links() }}
                </div>
            </div>

            <!-- Сервера -->
            <div>
                <form method="get" class="mb-2 flex gap-2">
                    <input type="text" name="search_server" value="{{ request('search_server') }}"
                           placeholder="Поиск по серверам"
                           class="px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 w-64">
                    <button class="px-4 py-2 bg-[#D90751] text-white rounded-lg font-semibold hover:bg-pink-700">Поиск</button>
                </form>
                <div class="overflow-x-auto rounded-xl shadow mb-10">
                    <table class="min-w-full table-fixed w-full divide-y divide-gray-700 bg-gray-900 rounded-xl">
                        <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wider bg-gray-800">
                            <th class="w-16 px-6 py-3">ID</th>
                            <th class="px-6 py-3 text-left">Сервер</th>
                            <th class="px-6 py-3 text-left">Тип</th>
                            <th class="px-6 py-3 text-left">Игра</th>
                            <th class="px-6 py-3 text-left">Дата создания</th>
                            <th class="w-40 px-6 py-3 text-center">Управление</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-sm">
                        @foreach($servers as $server)
                            <tr>
                                <td class="w-16 px-6 py-3 text-[#D90751]">{{ $server->id }}</td>
                                <td class="px-6 py-3">{{ $server->server_name }}</td>
                                <td class="px-6 py-3">{{ $server->type->type_name ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $server->game->title ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $server->created_at->format('d.m.Y H:i') }}</td>
                                <td class="w-40 px-6 py-3 text-center">
                                    <a href="#" class="text-[#D90751] hover:underline">Редактировать</a>
                                    <span class="mx-1 text-gray-500">|</span>
                                    <a href="#" class="text-red-400 hover:underline">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $servers->appends(request()->except('servers_page'))->links() }}
                    </div>
                </div>

                <div class="mt-2">
                    {{ $servers->appends(['search_server' => request('search_server')])->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
