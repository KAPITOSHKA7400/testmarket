@extends('layouts.app')

@section('content')
    <div class="min-h-screen">

        <div class="flex flex-wrap justify-center gap-8 pt-8 pb-8 relative">
            <!-- Меню категорий -->
            <nav class="flex flex-wrap gap-8">
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Обнаружить</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Анимация</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Брендинг</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Иллюстрация</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Мобильные</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Дизайн продукта</a>
                <a href="#" class="font-semibold text-gray-200 hover:text-orange-400 transition">Веб-дизайн</a>
            </nav>
            <!-- Фильтр сортировки -->
            <form method="GET" action="{{ url('/') }}" class="absolute right-0 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-200 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-.293.707l-6.414 6.414A2 2 0 0 0 13 14.586V19a1 1 0 0 1-1.447.894l-2-1A1 1 0 0 1 9 18v-3.414a2 2 0 0 0-.586-1.414L2 6.707A1 1 0 0 1 1.707 6V4z"/>
                </svg>
                <select name="sort" onchange="this.form.submit()"
                        class="bg-gray-900 border border-gray-700 text-gray-200 rounded px-3 py-1 focus:ring-orange-400 focus:border-orange-400 transition">
                    <option value="recent" {{ ($sort ?? 'recent') == 'recent' ? 'selected' : '' }}>Недавно загруженные</option>
                    <option value="popular" {{ ($sort ?? '') == 'popular' ? 'selected' : '' }}>Популярные</option>
                </select>
            </form>
        </div>

        <div x-data="{
                open: false,
                work: {},
                showModal(data) {
                    this.work = data;
                    this.open = true;
                }
            }">
            <div class="container mx-auto px-4 pb-10">
                <div id="works-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-8">
                    @forelse($works as $work)
                        @include('partials._work_card', ['work' => $work])
                    @empty
                        <div class="col-span-5 text-gray-500 text-center py-8">Работ пока нет</div>
                    @endforelse
                </div>

                <!-- Кнопка загрузить больше -->
                @if($works->count() >= $limit)
                    @auth
                        <div
                            x-data="{
                                limit: 13,
                                offset: {{ count($works) }},
                                loading: false,
                                allLoaded: false,
                                loadMore() {
                                    this.loading = true;
                                    fetch(`/?limit=${this.limit}&offset=${this.offset}&sort={{ $sort }}`, {
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                    })
                                    .then(res => res.text())
                                    .then(html => {
                                        if (html.trim() === '') {
                                            this.allLoaded = true;
                                            return;
                                        }
                                        document.getElementById('works-list').insertAdjacentHTML('beforeend', html);
                                        this.offset += this.limit;
                                        // Если работ на странице стало столько же, сколько totalWorks — скрыть кнопку
                                        if (this.offset >= {{ $totalWorks }}) this.allLoaded = true;
                                    })
                                    .finally(() => this.loading = false);
                                }
                            }"
                            class="flex flex-col items-center mt-12"
                            x-show="!allLoaded">
                            <button
                                @click="loadMore"
                                x-bind:disabled="loading"
                                class="bg-transparent hover:bg-orange-600 text-orange-400 font-semibold py-2 px-6 border border-orange-400 rounded transition">
                                <span x-show="!loading">Показать больше работ</span>
                                <span x-show="loading" style="display:none;">Загрузка...</span>
                            </button>
                        </div>
                    @else
                        <div x-data="{ showAuthModal: false }" class="flex flex-col items-center mt-12">
                            <button
                                class="bg-transparent text-orange-400 font-semibold py-2 px-6 border border-orange-400 rounded transition cursor-pointer opacity-80"
                                @click="showAuthModal = true">
                                Показать больше работ
                            </button>
                            <!-- Модалка авторизации ... -->
                            <!-- ...оставь тут всё как было для гостей... -->
                        </div>
                    @endauth
                @endif
            </div>

            <!-- ОДНА ОБЩАЯ МОДАЛКА -->
            <div x-show="open"
                 x-transition
                 @click.self="open = false"
                 class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
                 style="display: none;">

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

    <script>
        function registerWorkView(workId) {
            fetch(`/works/${workId}/view`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
        }
    </script>

@endsection
