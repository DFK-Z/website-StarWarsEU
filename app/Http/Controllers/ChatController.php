<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Главная страница чата
     */
    public function index()
    {
        $user = Auth::user();

        // Проверяем, согласился ли пользователь с правилами
        if (!$user->chat_agreed_at) {
            return view('chat.rules');
        }

        $messages = Message::with('user')->latest()->limit(100)->get()->reverse();
        $users = User::where('id', '!=', Auth::id())->get();

        return view('chat.index', compact('messages', 'users'));
    }

    /**
     * Принять правила чата
     */
    public function agree(Request $request)
    {
        $request->validate([
            'agree' => 'required|accepted',
        ]);

        $user = Auth::user();

        // ПРЯМОЕ ОБНОВЛЕНИЕ БЕЗ МЕТОДА
        $user->chat_agreed_at = now();
        $user->save();

        return redirect()->route('chat.index')->with('success', '✅ Добро пожаловать в Галактический чат!');
    }

    /**
     * Отправить сообщение
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        if (!$user->chat_agreed_at) {
            return redirect()->route('chat.index')->with('error', '❌ Вы должны принять Кодекс Хранителя, чтобы писать в чат.');
        }

        if (!$this->canSendMessage($user)) {
            return back()->with('error', '❌ Вы забанены в чате.');
        }

        Message::create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return redirect()->route('chat.index')->with('success', '✅ Сообщение отправлено!');
    }

    /**
     * Проверка: может ли пользователь отправлять сообщения
     */
    private function canSendMessage($user)
    {
        // Админы и модераторы не могут быть забанены
        if ($user->isAdmin() || $user->isModerator()) {
            return true;
        }
        return !$user->is_banned;
    }

    /**
     * Забанить пользователя в чате (только для модераторов и админов)
     */
    public function banUser(Request $request, User $user)
    {
        if (!Auth::user()->isModerator()) {
            abort(403, '❌ У вас нет прав на бан.');
        }

        // Нельзя забанить админа или модератора
        if ($user->isModerator() || $user->isAdmin()) {
            return back()->with('error', '❌ Нельзя забанить Рыцаря Хронологии или Верховного Хранителя.');
        }

        $request->validate([
            'reason' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        Ban::create([
            'user_id' => $user->id,
            'banned_by' => Auth::id(),
            'reason' => $request->reason,
            'expires_at' => $request->expires_at,
        ]);

        $user->update(['is_banned' => true]);

        return back()->with('success', "✅ Пользователь '{$user->name}' забанен в чате.");
    }

    /**
     * Разбанить пользователя в чате (только для модераторов и админов)
     */
    public function unbanUser(User $user)
    {
        if (!Auth::user()->isModerator()) {
            abort(403, '❌ У вас нет прав на разбан.');
        }

        Ban::where('user_id', $user->id)->delete();
        $user->update(['is_banned' => false]);

        return back()->with('success', "✅ Пользователь '{$user->name}' разбанен.");
    }
}
