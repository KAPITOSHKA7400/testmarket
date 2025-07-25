@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4 bg-white dark:bg-gray-900 p-8 rounded-xl shadow flex flex-col items-center">
        @if(Auth::user()->role === 'user_des')
            <!-- Верхний блок профиля и меню -->
            <div class="flex flex-col items-center mb-6">
                <img src="{{ Auth::user()->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                     alt="Аватар"
                     class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    {{ Auth::user()->login }}
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-full font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16.862 3.487a2.062 2.062 0 1 1 2.92 2.92l-12.293 12.293-3.094.344.344-3.094L16.862 3.487z"/>
                    </svg>
                    Редактировать профиль
                </a>
            </div>

            <!-- Навигационное меню для Дизайнера -->
            <nav class="w-full flex justify-center mt-8 gap-4">
                <a href="{{ route('profile') }}"
                   class="px-4 py-2 rounded-lg font-medium
            {{ request()->routeIs('profile') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-700 dark:hover:text-white' }}
            transition">Мои работы
                </a>
                <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 transition">Коллекции</a>
                <a href="{{ route('profile.favorites') }}"
                   class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white transition">
                    Понравившееся
                </a>
                <a href="{{ route('profile.about') }}" class="px-4 py-2 rounded-lg font-medium
            {{ request()->routeIs('profile.about') ? 'bg-red-700 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-red-900 dark:hover:text-white' }}
            transition">Обо мне
                </a>
            </nav>

            <!-- Alpine.js State -->
            <div
                x-data="profilePage()"
                class="w-full"
            >
                <!-- Кнопка для открытия формы загрузки -->
                <div class="w-full flex justify-start mt-10 mb-4">
                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded shadow transition"
                        @click="uploadOpen = true"
                    >
                        Добавить работу
                    </button>
                </div>

                <!-- Модалка загрузки работы -->
                <div
                    x-show="uploadOpen"
                    x-transition
                    @click.self="uploadOpen = false"
                    class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center"
                    style="display: none;"
                >
                    <div class="bg-[#222] rounded-xl shadow-xl w-full max-w-md p-8 flex flex-col gap-4 relative">
                        <button @click="uploadOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-orange-400 text-2xl font-bold">&times;</button>
                        <form action="{{ route('profile.addwork') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                            @csrf
                            <label class="text-sm font-medium text-gray-200">Название работы:</label>
                            <input type="text" name="title" required class="w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200" value="{{ old('title') }}">
                            @error('title')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror

                            <label class="text-sm font-medium text-gray-200">Описание работы:</label>
                            <textarea name="description" required rows="3" class="w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror

                            <label class="text-sm font-medium text-gray-200">Добавить работы (можно выбрать несколько файлов):</label>
                            <input type="file" name="work_file[]" multiple accept="image/png,image/jpeg,image/gif,image/webp,video/mp4,video/webm"
                                   class="w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200">
                            @error('work_file')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror

                            <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold transition">
                                Загрузить
                            </button>
                        </form>
                    </div>
                </div>

                <!-- GRID: все работы пользователя -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mt-8 w-full">
                    @foreach (Auth::user()->works as $work)
                        @php
                            $gallery = [];
                            if ($work->is_gallery) {
                                $gallery = Auth::user()->works
                                    ->where('gallery_group', $work->gallery_group)
                                    ->sortBy('id')
                                    ->values()
                                    ->map(function($item){
                                        return [
                                            'type' => $item->type,
                                            'file' => asset('storage/' . $item->file)
                                        ];
                                    })
                                    ->toArray();
                            }
                            $workJson = [
                                'id' => $work->id,
                                'user' => [
                                    'login' => Auth::user()->login,
                                    'avatar' => Auth::user()->avatar ?? '',
                                ],
                                'type' => $work->type,
                                'file' => asset('storage/' . $work->file),
                                'title' => $work->title ?? 'Без названия',
                                'description' => $work->description ?? '',
                                'is_gallery' => (bool) $work->is_gallery,
                                'gallery' => $gallery,
                            ];
                        @endphp
                        @if ($work->is_gallery == 0 || $work->gallery_main == 1)
                            <div
                                class="bg-gray-800 p-4 rounded-lg shadow flex flex-col items-center relative group cursor-pointer"
                                @click="openWork({{ $work->id }})"
                            >
                                <input type="hidden" x-ref="work{{ $work->id }}" value='@json($workJson)'>

                                @if ($work->type == 'image')
                                    <img src="{{ asset('storage/' . $work->file) }}"
                                         class="w-full h-48 object-cover rounded mb-2"
                                         alt="">
                                @elseif ($work->type == 'video')
                                    <video src="{{ asset('storage/' . $work->file) }}"
                                           class="w-full h-48 rounded mb-2"
                                           controls preload="metadata"></video>
                                @endif

                                <!-- ... Лайки и кнопки ... -->
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Модалка просмотра работы -->
                <div
                    x-show="modalOpen"
                    x-transition
                    @click.self="closeModal"
                    class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
                    style="display: none;"
                >
                    <div class="bg-[#232323] rounded-xl shadow-2xl w-[1400px] max-w-full flex relative overflow-hidden">
                        <!-- Левая часть: Инфо и работа -->
                        <div class="flex-[2] min-w-0 p-12 flex flex-col justify-center items-center relative">
                            <button @click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-orange-400 text-2xl font-bold">&times;</button>
                            <div class="flex items-center gap-2 mb-6">
                                <img :src="selectedWork?.user?.avatar || 'https://placehold.co/40x40/png'" class="w-10 h-10 rounded-full" alt="avatar">
                                <span class="text-lg font-semibold text-gray-200" x-text="selectedWork?.user?.login"></span>
                            </div>
                            <div class="font-bold text-3xl text-white mb-4 text-center" x-text="selectedWork?.title"></div>

                            <!-- Галерея с миниатюрами КАРТИНКА + ВИДЕО -->
                            <template x-if="selectedWork && selectedWork.is_gallery && selectedWork.gallery.length > 0">
                                <div class="flex flex-col items-center w-full">
                                    <div class="relative mb-4 w-full flex justify-center">
                                        <template x-if="selectedWork.gallery[currentIndex]?.type === 'image'">
                                            <img :src="selectedWork.gallery[currentIndex].file"
                                                 class="max-h-[700px] object-contain rounded-lg cursor-zoom-in"
                                                 style="max-width: 100%;"
                                                 @click="zoomImage(selectedWork.gallery[currentIndex].file)">
                                        </template>
                                        <template x-if="selectedWork.gallery[currentIndex]?.type === 'video'">
                                            <video :src="selectedWork.gallery[currentIndex].file"
                                                   class="max-h-[700px] rounded-lg cursor-zoom-in"
                                                   style="max-width: 100%;"
                                                   controls
                                                   @click="zoomVideo(selectedWork.gallery[currentIndex].file)">
                                            </video>
                                        </template>
                                        <button x-show="selectedWork.gallery.length > 1" @click="prevWork" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 rounded-full p-2 text-white z-10">&#8592;</button>
                                        <button x-show="selectedWork.gallery.length > 1" @click="nextWork" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 rounded-full p-2 text-white z-10">&#8594;</button>
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <template x-for="(item, idx) in selectedWork.gallery" :key="idx">
                                            <template x-if="item.type === 'image'">
                                                <img
                                                    :src="item.file"
                                                    class="w-16 h-16 rounded object-cover cursor-pointer border-2"
                                                    :class="{ 'border-orange-500': currentIndex === idx }"
                                                    @click="currentIndex = idx"
                                                >
                                            </template>
                                            <template x-if="item.type === 'video'">
                                                <video
                                                    :src="item.file"
                                                    class="w-16 h-16 rounded object-cover cursor-pointer border-2 bg-black"
                                                    :class="{ 'border-orange-500': currentIndex === idx }"
                                                    @click="currentIndex = idx"
                                                    preload="metadata"
                                                    muted
                                                    playsinline
                                                    @mouseenter="try{ $event.target.currentTime = 0; }catch(e){}"
                                                ></video>
                                            </template>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            <!-- Одиночная работа -->
                            <template x-if="selectedWork && !selectedWork.is_gallery">
                                <div>
                                    <template x-if="selectedWork.type === 'image'">
                                        <img :src="selectedWork.file"
                                             class="w-full max-h-[700px] object-contain rounded-lg mb-4 cursor-zoom-in"
                                             @click="zoomImage(selectedWork.file)">
                                    </template>
                                    <template x-if="selectedWork.type === 'video'">
                                        <video :src="selectedWork.file"
                                               class="w-full max-h-[700px] rounded-lg mb-4 cursor-zoom-in"
                                               controls
                                               @click="zoomVideo(selectedWork.file)"></video>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <!-- Правая часть: Описание и комментарии -->
                        <div class="flex-[1] w-[340px] bg-[#18191b] border-l border-gray-700 flex flex-col p-8 min-h-full">
                            <div class="mb-6">
                                <div class="font-semibold text-lg text-gray-100 mb-2" x-show="selectedWork?.description">Описание</div>
                                <div class="text-gray-400 text-sm" x-text="selectedWork?.description"></div>
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

                <!-- Модалка zoom (full screen) -->
                <div x-show="zoomSrc !== null" class="fixed inset-0 z-[999] bg-black/90 flex items-center justify-center" style="display:none" @click.self="closeZoom">
                    <template x-if="zoomType === 'image'">
                        <img :src="zoomSrc" class="max-w-full max-h-[98vh] object-contain" />
                    </template>
                    <template x-if="zoomType === 'video'">
                        <video :src="zoomSrc" class="max-w-full max-h-[98vh] rounded-lg" controls autoplay></video>
                    </template>
                    <button @click="closeZoom"
                            class="absolute top-6 right-10 text-white text-4xl font-bold hover:text-orange-400 transition z-50"
                            style="filter: drop-shadow(0 0 8px #000)">
                        &times;
                    </button>
                </div>
            </div>

            <script>
                function profilePage() {
                    return {
                        modalOpen: false,
                        uploadOpen: false,
                        selectedWork: null,
                        currentIndex: 0,
                        zoomSrc: null,
                        zoomType: null,
                        openWork(id) {
                            const json = this.$refs['work' + id].value;
                            this.selectedWork = JSON.parse(json);
                            this.currentIndex = 0;
                            this.modalOpen = true;
                        },
                        closeModal() {
                            this.modalOpen = false;
                            this.selectedWork = null;
                        },
                        nextWork() {
                            if (this.selectedWork && this.selectedWork.gallery && this.selectedWork.gallery.length > 0) {
                                this.currentIndex = (this.currentIndex + 1) % this.selectedWork.gallery.length;
                            }
                        },
                        prevWork() {
                            if (this.selectedWork && this.selectedWork.gallery && this.selectedWork.gallery.length > 0) {
                                this.currentIndex = (this.currentIndex - 1 + this.selectedWork.gallery.length) % this.selectedWork.gallery.length;
                            }
                        },
                        zoomImage(src) {
                            this.zoomSrc = src;
                            this.zoomType = 'image';
                        },
                        zoomVideo(src) {
                            this.zoomSrc = src;
                            this.zoomType = 'video';
                        },
                        closeZoom() {
                            this.zoomSrc = null;
                            this.zoomType = null;
                        }
                    }
                }
            </script>
        @else
            <!-- Остальные роли: общий блок профиля -->
            <div class="flex flex-col items-center mb-6">
                <img src="{{ Auth::user()->avatar ?? 'https://randomuser.me/api/portraits/men/12.jpg' }}"
                     alt="Аватар"
                     class="w-20 h-20 rounded-full object-cover border-4 border-gray-300 dark:border-gray-700 shadow mb-3">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    {{ Auth::user()->login }}
                </div>
                <div class="text-gray-700 dark:text-gray-300 mb-2">Email: {{ Auth::user()->email }}</div>
                <div class="mb-3">
                    Роль:
                    <span class="uppercase px-2 py-1 rounded
        @if(Auth::user()->role == 'admin') bg-red-100 text-red-600
        @elseif(Auth::user()->role == 'moder') bg-blue-100 text-blue-600
        @elseif(Auth::user()->role == 'user_dev') bg-purple-100 text-purple-600
        @elseif(Auth::user()->role == 'partner') bg-yellow-100 text-yellow-600
        @else bg-gray-100 text-gray-600
        @endif">
        {{ Auth::user()->role }}</span>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-full font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16.862 3.487a2.062 2.062 0 1 1 2.92 2.92l-12.293 12.293-3.094.344.344-3.094L16.862 3.487z"/>
                    </svg>
                    Редактировать профиль
                </a>
            </div>
            <!-- Навигационное меню для всех других -->
            <nav class="w-full flex justify-center mt-4 gap-4">
                <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900 transition">Мои данные</a>
                <a href="#" class="px-4 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900 transition">Обо мне</a>
            </nav>
        @endif
    </div>
@endsection
