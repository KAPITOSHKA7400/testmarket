<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Work;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
{
    // Показывает страницу профиля (view)
    public function show()
    {
        $user = auth()->user();
        $works = $user->works()->with('likes')->latest()->get();
        return view('profile', compact('user', 'works'));
    }

    public function showByLogin($login)
    {
        $user = \App\Models\User::where('login', $login)->firstOrFail();
        $works = $user->works()->with('likes')->latest()->get();
        return view('profile.show', compact('user', 'works'));
    }

    // Открывает форму редактирования
    public function edit(Request $request)
    {
        return view('profile.edit');
    }
    public function security() {
        $user = auth()->user();
        return view('profile.security', compact('user'));
    }

    public function social() {
        $user = auth()->user();
        return view('profile.social', compact('user'));
    }

    public function notifications() {
        $user = auth()->user();
        return view('profile.notifications', compact('user'));
    }

    public function sessions()
    {
        $user = auth()->user();

        // Получаем сессии пользователя по user_id (или по user_login/email если кастомно)
        $sessions = \DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        return view('profile.sessions', compact('user', 'sessions'));
    }



    // Обновляет данные профиля
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:64',
            'city' => 'nullable|string|max:64',
            'about' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->website = $request->website;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->about = $request->about;

        // Сохраняем аватар
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        }
        // Удаление аватарки
        if ($request->has('remove_avatar') && $request->remove_avatar) {
            $user->avatar = null;
        }

        // баннер для профиля
        if ($request->hasFile('user_banner')) {
            $path = $request->file('user_banner')->store('banners', 'public');
            $user->user_banner = $path;
        }

        $request->validate([
            'user_banner' => [
                'nullable',
                'image',
                'mimes:jpg,webp',
                'dimensions:width=1390,height=250',
            ],
        ]);

        if ($request->has('remove_user_banner')) {
            if ($user->user_banner && Storage::disk('public')->exists($user->user_banner)) {
                Storage::disk('public')->delete($user->user_banner);
            }
            $user->user_banner = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Профиль обновлён!');
    }


    // Удаляет пользователя
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function addWork(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_file' => 'required',
            'work_file.*' => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,webm',
        ]);

        $files = $request->file('work_file');
        $isGallery = count($files) > 1;
        $galleryGroup = $isGallery ? uniqid('gal_') : null;

        foreach ($files as $i => $file) {
            $type = (strpos($file->getMimeType(), 'video') !== false) ? 'video' : 'image';

            $work = new Work();
            $work->user_id = Auth::id();
            $work->title = $validated['title'];
            $work->description = $validated['description'];
            $work->file = $file->store('user_works', 'public');
            $work->type = $type;
            $work->is_gallery = $isGallery ? 1 : 0;
            $work->gallery_main = $isGallery && $i === 0 ? 1 : 0; // только первый — главный
            $work->gallery_group = $galleryGroup;
            $work->save();
        }

        return redirect()->route('profile')->with('success', 'Работа(ы) успешно добавлены!');
    }


    public function editWork(\App\Models\Work $work)
    {
        // Только владелец может редактировать!
        if ($work->user_id !== auth()->id()) abort(403);

        return view('profile.edit_work', compact('work'));
    }

    public function updateWork(Request $request, \App\Models\Work $work)
    {
        if ($work->user_id !== auth()->id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'work_file' => 'nullable|file|mimes:png,jpg,jpeg,gif,webp,mp4,webm|max:30720'
        ]);

        $work->title = $request->title;
        $work->description = $request->description;

        if ($request->hasFile('work_file')) {
            // Удаляем старый файл (по желанию)
            if ($work->file && \Storage::disk('public')->exists($work->file)) {
                \Storage::disk('public')->delete($work->file);
            }
            $dir = 'user_works/' . $work->user_id;
            $file = $request->file('work_file');
            $path = $file->store($dir, 'public');
            $work->file = $path;
            $work->type = \Illuminate\Support\Str::startsWith($file->getMimeType(), 'image') ? 'image' : 'video';
        }

        $work->save();

        return redirect()->route('profile')->with('success', 'Работа успешно обновлена!');
    }

    public function deleteWork(\App\Models\Work $work)
    {
        // Только владелец может удалять свою работу!
        if (auth()->id() !== $work->user_id) {
            abort(403, 'Нет доступа');
        }

        // Удалить файл с диска, если нужно:
        if ($work->file && \Storage::disk('public')->exists($work->file)) {
            \Storage::disk('public')->delete($work->file);
        }

        $work->delete();

        return back()->with('success', 'Работа удалена!');
    }

    public function likeWork(\App\Models\Work $work)
    {
        $user = auth()->user();
        if (!$work->isLikedBy($user)) {
            $work->likes()->create(['user_id' => $user->id]);
        }
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back();
    }

    public function unlikeWork(\App\Models\Work $work)
    {
        $user = auth()->user();
        $work->likes()->where('user_id', $user->id)->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back();
    }

    public function favorites(Request $request)
    {
        $user = $request->user();
        $works = $user->likedWorks()->with('user', 'likes')->latest()->get();
        return view('profile.favorites', compact('works'));
    }

    public function about()
    {
        return view('profile.about');
    }


}

