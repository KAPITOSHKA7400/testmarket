<x-app-layout>
    <h1>{{ $work->title }}</h1>
    <p>{{ $work->description }}</p>
    <span>👁 {{ number_format_short($work->views_count) }}</span>
</x-app-layout>
