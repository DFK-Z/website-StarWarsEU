<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'is_banned',        // <-- ДОБАВЛЕНО!
        'chat_agreed_at',   // <-- ДОБАВЛЕНО!
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',           // <-- ДОБАВЛЕНО!
            'chat_agreed_at' => 'datetime',     // <-- ДОБАВЛЕНО!
        ];
    }

    /**
     * Получить URL аватарки
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4A9EFF&color=0B0D10&size=100';
    }

    /**
     * Получить название роли на русском (Star Wars стиль)
     */
    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            'admin'     => '🔴 Верховный Хранитель',
            'moderator' => '🔵 Рыцарь Хронологии',
            'guardian'  => '🟣 Хранитель Знаний',
            default     => '🟢 Хранитель Голокрона',
        };
    }

    /**
     * Получить CSS-класс для роли
     */
    public function getRoleClassAttribute(): string
    {
        return match ($this->role) {
            'admin'     => 'role-master',
            'moderator' => 'role-knight',
            'guardian'  => 'role-guardian',
            default     => 'role-keeper',
        };
    }

    /**
     * Получить бейдж роли для отображения
     */
    public function getRoleBadgeAttribute(): string
    {
        return '<span class="role-badge ' . $this->role_class . '">' . $this->role_name . '</span>';
    }

    /**
     * Проверки ролей
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['moderator', 'admin']);
    }

    public function isGuardian(): bool
    {
        return $this->role === 'guardian';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isAtLeast(string $role): bool
    {
        $levels = ['user' => 0, 'guardian' => 1, 'moderator' => 2, 'admin' => 3];
        return ($levels[$this->role] ?? 0) >= ($levels[$role] ?? 0);
    }

    /**
     * Проверка: забанен ли пользователь в чате
     */
    public function isBannedFromChat(): bool
    {
        if ($this->is_banned) {
            return true;
        }

        $activeBan = Ban::where('user_id', $this->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->exists();

        return $activeBan;
    }

    /**
     * Получить активный бан
     */
    public function getActiveBan()
    {
        return Ban::where('user_id', $this->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->first();
    }

    /**
     * Может ли пользователь писать в чат
     */
    public function canSendMessage(): bool
    {
        // Админы и модераторы не могут быть забанены
        if ($this->isAdmin() || $this->isModerator()) {
            return true;
        }
        return !$this->isBannedFromChat();
    }

    /**
     * Получить количество непрочитанных сообщений
     */
    public function getUnreadMessagesCountAttribute(): int
    {
        return PrivateMessage::getUnreadCount($this->id);
    }

    /**
     * Получить список диалогов
     */
    public function getConversationsAttribute(): array
    {
        return PrivateMessage::getConversations($this->id);
    }

    /**
     * Проверка: согласился ли пользователь с правилами чата
     */
    public function hasAgreedToChat(): bool
    {
        return $this->chat_agreed_at !== null;
    }

    /**
     * Отметить, что пользователь согласился с правилами
     */
    public function agreeToChat(): void
    {
        $this->update(['chat_agreed_at' => now()]);
    }
}
