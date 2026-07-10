<?php

namespace App\Http\Controllers;

use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessageController extends Controller
{
    /**
     * Список диалогов
     */
    public function index()
    {
        $conversations = PrivateMessage::getConversations(Auth::id());
        return view('dm.index', compact('conversations'));
    }

    /**
     * Чат с конкретным пользователем
     */
    public function show(User $user)
    {
        $conversationId = PrivateMessage::generateConversationId(Auth::id(), $user->id);
        $messages = PrivateMessage::getConversation(Auth::id(), $user->id);

        // Отмечаем сообщения как прочитанные
        PrivateMessage::markAsRead(Auth::id(), $user->id);

        $otherUser = $user;

        return view('dm.show', compact('messages', 'otherUser', 'conversationId'));
    }

    /**
     * Отправить сообщение
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $receiver = User::find($request->receiver_id);

        // Проверка: не отправляем себе
        if ($receiver->id === Auth::id()) {
            return back()->with('error', '❌ Нельзя отправлять сообщения самому себе.');
        }

        // Проверка: если у пользователя есть бан в чате, он не может писать в ДМ
        if (Auth::user()->isBannedFromChat() && !Auth::user()->isModerator()) {
            return back()->with('error', '❌ Вы забанены в чате.');
        }

        $conversationId = PrivateMessage::generateConversationId(Auth::id(), $receiver->id);

        $message = PrivateMessage::create([
            'conversation_id' => $conversationId,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        // Перенаправляем обратно в чат с этим пользователем
        return redirect()->route('dm.show', $receiver)->with('success', '✅ Сообщение отправлено!');
    }

    /**
     * Получить количество непрочитанных (для API или ajax)
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => PrivateMessage::getUnreadCount(Auth::id()),
        ]);
    }
}
