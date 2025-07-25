<div class="flex flex-col relative">
    <!-- Картинка/видео — только по ним открывается модалка! -->
    @if($work->type == 'image')
        <img src="{{ asset('storage/' . $work->file) }}" alt="work"
            class="object-cover w-full h-48 rounded-xl group-hover:scale-105 transition cursor-pointer"
            @click="showModal({
                id: {{ $work->id }},
                user: { login: `{{ addslashes($work->user->login ?? 'Без имени') }}`, avatar: '{{ $work->user->avatar ?? '' }}' },
                type: '{{ $work->type }}',
                file: '{{ asset('storage/' . $work->file) }}',
                title: `{{ addslashes($work->title ?? 'Без названия') }}`,
                description: `{{ addslashes($work->description ?? '') }}`
             })"
        />
    @else
        <video src="{{ asset('storage/' . $work->file) }}" class="object-cover w-full h-48 rounded-xl group-hover:scale-105 transition cursor-pointer"
            @click="showModal({
                id: {{ $work->id }},
                user: { login: `{{ addslashes($work->user->login ?? 'Без имени') }}`, avatar: '{{ $work->user->avatar ?? '' }}' },
                type: '{{ $work->type }}',
                file: '{{ asset('storage/' . $work->file) }}',
                title: `{{ addslashes($work->title ?? 'Без названия') }}`,
                description: `{{ addslashes($work->description ?? '') }}`
             })"
            controls
        ></video>
    @endif
    <div class="px-4 py-3 flex flex-col gap-2 flex-1 justify-between h-full">
        <div class="flex items-center justify-between w-full">
            <!-- Ссылка на профиль автора -->
            <a href="{{ url('/' . $work->user->login) }}" class="flex items-center gap-2 hover:underline">
                <img src="{{ $work->user->avatar ?? 'https://placehold.co/24x24/png' }}" class="w-6 h-6 rounded-full" alt="avatar">
                <span class="text-sm font-medium text-gray-200">{{ $work->user->login ?? 'Без имени' }}</span>
            </a>
            <!-- Блок лайков AJAX -->
            <div x-data="{
            liked: {{ $work->isLikedBy(auth()->user()) ? 'true' : 'false' }},
            likesCount: {{ $work->likes->count() }},
            toggleLike() {
                const url = this.liked
                    ? '{{ route('work.unlike', $work) }}'
                    : '{{ route('work.like', $work) }}';
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(r => {
                    if (r.ok) {
                        this.liked = !this.liked;
                        this.likesCount = this.liked
                            ? this.likesCount + 1
                            : this.likesCount - 1;
                    }
                });
            }
        }" class="flex items-center gap-2 text-sm text-gray-400 mt-2 select-none">
                <button @click.stop.prevent="toggleLike()" class="focus:outline-none">
                    <template x-if="liked">
                        <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                        </svg>
                    </template>
                    <template x-if="!liked">
                        <svg class="w-5 h-5 text-gray-400 hover:text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 20 20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0l.318.318.318-.318a4.5 4.5 0 116.364 6.364L10 17.036l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                        </svg>
                    </template>
                </button>
                <span x-text="likesCount"></span>
            </div>
            <span>👁 {{ number_format_short($work->views_count) }}</span>
        </div>
    </div>
</div>
