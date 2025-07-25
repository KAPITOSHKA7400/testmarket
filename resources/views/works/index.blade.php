<div class="flex items-center space-x-2">
    <span>❤️ {{ $work->likes->count() }}</span>
    <span>👁 {{ number_format_short($work->views_count) }}</span>
</div>
