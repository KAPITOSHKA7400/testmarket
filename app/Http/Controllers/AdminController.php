<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\ProductType;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Нет доступа');
        }

        return view('profile.admin');
    }

    public function users(Request $request)
    {
        $query = \App\Models\User::query();

        // Поиск
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('login', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Сортировка
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        if (in_array($sort, ['id','login','role','email','created_at'])) {
            $query->orderBy($sort, $order);
        }

        // Пагинация по 25
        $users = $query->paginate(25)->appends($request->all());

        return view('admin.users', compact('users', 'sort', 'order', 'search'));
    }
    public function games()
    {
        return view('admin.games');
    }

    // Страница управления играми, типами товаров и серверами
    public function gamesPage(Request $request)
    {
        // --- Игры ---
        $gamesQuery = \App\Models\Game::query();
        if ($searchGame = $request->input('search_game')) {
            $gamesQuery->where('title', 'like', "%{$searchGame}%");
        }
        $games = $gamesQuery->orderBy('id', 'desc')->paginate(25, ['*'], 'games_page');

        // --- Типы товаров ---
        $typesQuery = \App\Models\ProductType::with('game');
        if ($searchType = $request->input('search_type')) {
            $typesQuery->where('type_name', 'like', "%{$searchType}%");
        }
        $types = $typesQuery->orderBy('id', 'desc')->paginate(25, ['*'], 'types_page');

        // --- Сервера ---
        $serversQuery = \App\Models\Server::with(['game', 'type']);
        if ($searchServer = $request->input('search_server')) {
            $serversQuery->where('server_name', 'like', "%{$searchServer}%");
        }
        $servers = $serversQuery->orderBy('id', 'desc')->paginate(25, ['*'], 'servers_page');

        // Для селектов:
        $allGames = \App\Models\Game::all();
        $allTypes = \App\Models\ProductType::with('game')->get();

        return view('admin.games', compact('games', 'types', 'servers', 'allGames', 'allTypes'));
    }


    public function storeGame(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:games,title',
        ]);

        \App\Models\Game::create([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.games')->with('success', 'Игра успешно добавлена!');
    }

    public function storeProductType(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'type_name' => 'required|string|max:255',
        ]);

        ProductType::create([
            'game_id' => $request->game_id,
            'type_name' => $request->type_name,
        ]);

        return redirect()->route('admin.games')->with('success', 'Тип товаров успешно добавлен!');
    }

    public function storeServer(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'type_id' => 'required|exists:product_types,id',
            'server_name' => 'required|string|max:255',
        ]);

        \App\Models\Server::create([
            'game_id' => $request->game_id,
            'type_id' => $request->type_id,
            'server_name' => $request->server_name,
        ]);

        return redirect()->route('admin.games')->with('success', 'Сервер успешно добавлен!');
    }


}
