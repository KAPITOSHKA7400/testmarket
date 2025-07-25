<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || $user->status !== 'active') {
            abort(403, 'Аккаунт не активен.');
        }

        return $next($request);
    }
}
