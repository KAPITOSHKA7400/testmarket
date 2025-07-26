@extends('layouts.app')

@section('content')

    <div class="container mx-auto mt-0 bg-white dark:bg-[#151920] rounded-xl overflow-hidden shadow flex flex-col items-center">
        @include('profile._admin_nav')
        <div class="w-full p-6 pt-0">
            <h1 class="text-2xl font-bold mb-4">Пользователи</h1>

            <div class="bg-white dark:bg-[#151920] rounded-xl shadow p-4 mb-6 border border-gray-200 dark:border-gray-800">
                <form method="get" class="flex flex-col sm:flex-row gap-2 sm:gap-4 items-center">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Поиск по логину или email"
                           class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-[#D90751] w-full sm:w-72 transition">
                    <button type="submit" class="px-6 py-2 bg-[#D90751] hover:bg-pink-700 rounded-lg text-white font-bold transition">Поиск</button>
                </form>
            </div>

            <div class="overflow-x-auto rounded-xl shadow">
                <table class="min-w-full w-full bg-white dark:bg-[#151920] rounded-xl border border-gray-200 dark:border-gray-800">
                    <thead>
                    <tr class="text-xs uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                        <th class="px-6 py-3 w-20 text-center">ID
                            <a href="?sort=id&order={{ ($sort === 'id' && $order === 'asc') ? 'desc' : 'asc' }}{{ $search ? '&search='.$search : '' }}">
                                @if($sort === 'id') <i class="fa-solid fa-caret-{{ $order === 'asc' ? 'up' : 'down' }}"></i> @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left">Логин</th>
                        <th class="px-6 py-3 text-left">Роль</th>
                        <th class="px-6 py-3 text-left">E-mail</th>
                        <th class="px-6 py-3 text-left">Дата регистрации</th>
                        <th class="px-6 py-3 text-center">Управление</th>
                    </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-3 text-center font-mono text-[#D90751]">{{ $user->id }}</td>
                            <td class="px-6 py-3 text-left text-gray-900 dark:text-gray-100">{{ $user->login }}</td>
                            <td class="px-6 py-3 text-left">
                            <span class="inline-block rounded-lg px-2 py-1 text-xs font-semibold
                                {{ $user->role === 'admin'
                                    ? 'bg-pink-900 text-[#D90751]'
                                    : 'bg-gray-800 dark:bg-gray-700 text-gray-300 dark:text-gray-200' }}">
                                {{ $user->role }}
                            </span>
                            </td>
                            <td class="px-6 py-3 text-left text-gray-900 dark:text-gray-100">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-left text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="#" class="text-[#D90751] hover:underline font-semibold">Управление</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 px-3 text-center text-gray-400 dark:text-gray-500">Пользователи не найдены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
