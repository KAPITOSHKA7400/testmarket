@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="max-w-lg mx-auto bg-gray-800 p-8 rounded-xl shadow">
            <h1 class="text-2xl font-bold text-white mb-6">Редактировать работу</h1>
            <form action="{{ route('work.update', $work->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <label class="block text-gray-300 mb-1">Название работы:</label>
                <input type="text" name="title" value="{{ old('title', $work->title) }}" required
                       class="block w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200">
                @error('title') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                <label class="block text-gray-300 mb-1">Описание работы:</label>
                <textarea name="description" rows="3" required
                          class="block w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200">{{ old('description', $work->description) }}</textarea>
                @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                <div class="mb-3">
                    <label class="block text-gray-300 mb-1">Текущий файл:</label>
                    @if($work->type == 'image')
                        <img src="{{ asset('storage/' . $work->file) }}" class="rounded mb-2 max-h-40">
                    @else
                        <video src="{{ asset('storage/' . $work->file) }}" class="rounded mb-2 max-h-40" controls></video>
                    @endif
                </div>

                <label class="block text-gray-300 mb-1">Заменить файл (не обязательно):</label>
                <input type="file" name="work_file"
                       accept="image/png,image/jpeg,image/gif,image/webp,video/mp4,video/webm"
                       class="block w-full border border-gray-600 rounded px-2 py-1 bg-gray-900 text-gray-200">
                @error('work_file') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold transition">
                    Сохранить
                </button>
            </form>
        </div>
    </div>
@endsection
