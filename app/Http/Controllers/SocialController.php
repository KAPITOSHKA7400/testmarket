<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Пример сохранения: предполагается, что у пользователя есть соответствующие поля
        $fields = [
            'telegram', 'vk', 'xcom', 'github', 'codepen',
            'behance', 'linkedin', 'vimeo', 'youtube'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $user->{$field} = $request->input($field);
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Социальные сети обновлены.');
    }
}
