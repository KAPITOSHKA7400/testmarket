<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Показать форму регистрации.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Обработка регистрации пользователя.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'login' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'wait',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Регистрация прошла успешно!');
    }
}
