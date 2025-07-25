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
        <h1 class="text-2xl font-bold mb-6">Активные сессии</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-3 py-2 border-b">ID сессии</th>
                    <th class="px-3 py-2 border-b">Создана</th>
                    <th class="px-3 py-2 border-b">IP</th>
                    <th class="px-3 py-2 border-b">Девайс</th>
                    <th class="px-3 py-2 border-b">ОС</th>
                    <th class="px-3 py-2 border-b">Последняя активность</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sessions as $session)
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800">
                        <td class="px-3 py-2 border-b font-mono">{{ substr($session->id, 0, 10) . '...' }}
                        </td>
                        <td class="px-3 py-2 border-b">
                            {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-3 py-2 border-b">{{ $session->ip_address ?? '-' }}</td>
                        <td class="px-3 py-2 border-b">
                            {{ $session->user_agent ? \Illuminate\Support\Str::limit($session->user_agent, 20) : '-' }}
                        </td>
                        <td class="px-3 py-2 border-b">
                            @if($session->user_agent)
                                @php
                                    // Для простого разбора (можно юзать сторонний пакет)
                                    if(stripos($session->user_agent, 'Windows') !== false) $os = 'Windows';
                                    elseif(stripos($session->user_agent, 'Mac OS') !== false) $os = 'macOS';
                                    elseif(stripos($session->user_agent, 'Linux') !== false) $os = 'Linux';
                                    elseif(stripos($session->user_agent, 'Android') !== false) $os = 'Android';
                                    elseif(stripos($session->user_agent, 'iPhone') !== false || stripos($session->user_agent, 'iPad') !== false) $os = 'iOS';
                                    else $os = 'Не определено';
                                @endphp
                                {{ $os }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-3 py-2 border-b">
                            {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">Активных сессий не найдено</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
