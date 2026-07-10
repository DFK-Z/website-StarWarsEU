<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'content',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Сгенерировать ID беседы для двух пользователей
     */
    public static function generateConversationId(int $user1, int $user2): string
    {
        $ids = [$user1, $user2];
        sort($ids);
        return implode('-', $ids);
    }

    /**
     * Получить все сообщения беседы
     */
    public static function getConversation(int $user1, int $user2)
    {
        $conversationId = self::generateConversationId($user1, $user2);
        return self::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Отметить сообщения как прочитанные
     */
    public static function markAsRead(int $userId, int $otherUserId)
    {
        $conversationId = self::generateConversationId($userId, $otherUserId);
        return self::where('conversation_id', $conversationId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Получить количество непрочитанных сообщений для пользователя
     */
    public static function getUnreadCount(int $userId): int
    {
        return self::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Получить список диалогов пользователя
     */
    public static function getConversations(int $userId)
    {
        // Находим все уникальные беседы, в которых участвовал пользователь
        $conversationIds = self::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->distinct()
            ->pluck('conversation_id');

        $conversations = [];

        foreach ($conversationIds as $conversationId) {
            $ids = explode('-', $conversationId);
            $otherId = $ids[0] == $userId ? $ids[1] : $ids[0];
            $otherUser = User::find($otherId);

            if ($otherUser) {
                $lastMessage = self::where('conversation_id', $conversationId)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $unreadCount = self::where('conversation_id', $conversationId)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();

                $conversations[] = [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'conversation_id' => $conversationId,
                    'updated_at' => $lastMessage ? $lastMessage->created_at : null,
                ];
            }
        }

        // Сортируем по дате последнего сообщения
        usort($conversations, function ($a, $b) {
            if (!$a['updated_at']) return 1;
            if (!$b['updated_at']) return -1;
            return $b['updated_at'] <=> $a['updated_at'];
        });

        return $conversations;
    }
}
