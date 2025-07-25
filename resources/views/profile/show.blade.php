@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 bg-white dark:bg-gray-900 p-8 rounded-xl shadow flex flex-col items-center">

        <!-- Верхний блок профиля -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ $user->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                 alt="Аватар"
                 class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ $user->login }}
            </div>
            <div class="mb-3">
                <span class="uppercase px-2 py-1 rounded
                @if($user->role == 'admin') bg-red-100 text-red-600
                @elseif($user->role == 'moder') bg-blue-100 text-blue-600
                @elseif($user->role == 'user_dev') bg-purple-100 text-purple-600
                @elseif($user->role == 'partner') bg-yellow-100 text-yellow-600
                @elseif($user->role == 'user_des') bg-orange-100 text-orange-600
                @else bg-gray-100 text-gray-600
                @endif
            ">
            @if($user->role == 'admin') Администратор
                    @elseif($user->role == 'moder') Модератор
                    @elseif($user->role == 'user_dev') Разработчик
                    @elseif($user->role == 'partner') Партнёр
                    @elseif($user->role == 'user_des') Дизайнер
                    @else {{ $user->role }}
                    @endif
            </span>
            </div>
            <!-- Здесь НЕТ кнопки редактирования! -->
        </div>

        <!-- Навигационное меню -->
        <nav class="w-full flex justify-center mt-8 gap-4">
            <a href="{{ url('/' . $user->login) }}"
               class="px-4 py-2 rounded-lg font-medium
              {{ request()->routeIs('profile.bylogin') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-700 dark:hover:text-white' }}
              transition">
                Работы
            </a>
            <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 transition">Коллекции</a>
            <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 transition">Обо мне</a>
        </nav>

        <!-- GRID + Модалка -->
        <div
            x-data="{
            open: false,
            work: {},
            showModal(data) {
                this.work = data;
                this.open = true;
            }
        }"
            class="w-full"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mt-8 w-full">
                @foreach ($works as $work)
                    <div
                        class="bg-gray-800 p-4 rounded-lg shadow flex flex-col items-center relative group cursor-pointer"
                        @click="showModal({
                        id: {{ $work->id }},
                        user: { login: `{{ addslashes($user->login) }}`, avatar: '{{ $user->avatar ?? "" }}' },
                        type: '{{ $work->type }}',
                        file: '{{ asset('storage/' . $work->file) }}',
                        title: `{{ addslashes($work->title ?? 'Без названия') }}`,
                        description: `{{ addslashes($work->description ?? '') }}`
                    })"
                    >
                        @if ($work->type == 'image')
                            <img src="{{ asset('storage/' . $work->file) }}"
                                 class="w-full h-48 object-cover rounded mb-2"
                                 alt="">
                        @elseif ($work->type == 'video')
                            <video src="{{ asset('storage/' . $work->file) }}"
                                   class="w-full h-48 rounded mb-2"
                                   controls></video>
                        @endif

                        <!-- БЛОК ЛАЙКОВ (AJAX) -->
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
                        }" class="flex items-center gap-2 text-sm text-gray-400 mt-2 select-none"
                        >
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
                    </div>
                @endforeach
            </div>

            <!-- ОДНА ОБЩАЯ МОДАЛКА (такая же как в profile.blade.php) -->
            <div
                x-show="open"
                x-transition
                @click.self="open = false"
                class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
                style="display: none;"
            >
                <div class="bg-[#232323] rounded-xl shadow-2xl w-[1400px] max-w-full flex relative overflow-hidden">
                    <!-- Левая часть: Инфо и работа -->
                    <div class="flex-[2] min-w-0 p-12 flex flex-col justify-center items-center relative">
                        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-orange-400 text-2xl font-bold">&times;</button>
                        <div class="flex items-center gap-2 mb-6">
                            <img :src="(work.user && work.user.avatar) ? work.user.avatar : 'https://placehold.co/40x40/png'" class="w-10 h-10 rounded-full" alt="avatar">
                            <span class="text-lg font-semibold text-gray-200" x-text="work.user ? work.user.login : 'Неизвестный'"></span>
                        </div>
                        <div class="font-bold text-3xl text-white mb-4 text-center" x-text="work.title"></div>
                        <template x-if="work.type === 'image'">
                            <div x-data="{ zoom: false }">
                                <img :src="work.file"
                                     class="w-full max-h-[700px] object-contain rounded-lg mb-4 cursor-zoom-in"
                                     @click="zoom = true"/>
                                <!-- Фуллскрин просмотр -->
                                <div x-show="zoom"
                                     x-transition
                                     class="fixed inset-0 z-[999] bg-black/90 flex items-center justify-center"
                                     style="display:none"
                                     @click.self="zoom = false">
                                    <img :src="work.file" class="max-w-full max-h-[98vh] object-contain" />
                                    <button @click="zoom = false"
                                            class="absolute top-6 right-10 text-white text-4xl font-bold hover:text-orange-400 transition z-50"
                                            style="filter: drop-shadow(0 0 8px #000)">
                                        &times;
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template x-if="work.type === 'video'">
                            <div x-data="{ zoom: false }">
                                <video :src="work.file"
                                       class="w-full max-h-[700px] rounded-lg mb-4 cursor-zoom-in"
                                       controls
                                       @click="zoom = true"></video>
                                <!-- Фуллскрин просмотр для видео -->
                                <div x-show="zoom"
                                     x-transition
                                     class="fixed inset-0 z-[999] bg-black/90 flex items-center justify-center"
                                     style="display:none"
                                     @click.self="zoom = false">
                                    <video :src="work.file" controls autoplay
                                           class="max-w-full max-h-[98vh] rounded-lg"
                                    ></video>
                                    <button @click="zoom = false"
                                            class="absolute top-6 right-10 text-white text-4xl font-bold hover:text-orange-400 transition z-50"
                                            style="filter: drop-shadow(0 0 8px #000)">
                                        &times;
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- Правая часть: Описание и комментарии -->
                    <div class="w-[340px] bg-[#18191b] border-l border-gray-700 flex flex-col p-8 min-h-full">
                        <div class="mb-6">
                            <div class="font-semibold text-lg text-gray-100 mb-2" x-show="work.description">Описание</div>
                            <div class="text-gray-400 text-sm" x-text="work.description"></div>
                        </div>
                        <div class="flex-1 flex flex-col">
                            <div class="font-semibold text-lg text-gray-100 mb-2">Комментарии</div>
                            <div class="flex-1 overflow-y-auto mb-3">
                                <div class="text-gray-500 text-sm">Комментариев пока нет</div>
                            </div>
                            <form>
                                <input type="text" placeholder="Написать комментарий..." class="w-full px-3 py-2 rounded bg-gray-800 text-gray-100 border border-gray-600 mb-1">
                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded font-semibold transition">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /ОДНА ОБЩАЯ МОДАЛКА -->
        </div>
    </div>
@endsection
