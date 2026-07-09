<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'timeline';

    protected $fillable = [
        'title',
        'slug',
        'year',
        'type',
        'description',
        'image',
    ];

    /**
     * Получить цвет для типа
     */
    public function getTypeColorAttribute(): string
    {
        $colors = [
            'novel' => '#39FF14',
            'comic' => '#FF1744',
            'movie' => '#F1C40F',
            'game' => '#9B59B6',
            'event' => '#4A9EFF',
        ];
        return $colors[$this->type] ?? '#8892A0';
    }

    /**
     * Получить эмодзи для типа
     */
    public function getTypeEmojiAttribute(): string
    {
        $emojis = [
            'novel' => '📖',
            'comic' => '📚',
            'movie' => '🎬',
            'game' => '🎮',
            'event' => '⚔️',
        ];
        return $emojis[$this->type] ?? '📌';
    }

    /**
     * Получить название типа на русском
     */
    public function getTypeNameAttribute(): string
    {
        $names = [
            'novel' => 'Роман',
            'comic' => 'Комикс',
            'movie' => 'Фильм',
            'game' => 'Игра',
            'event' => 'Событие',
        ];
        return $names[$this->type] ?? 'Неизвестно';
    }

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-timeline.jpg');
    }

    /**
     * Создать slug из названия
     */
    public static function generateSlug(string $title): string
    {
        $slug = \Str::slug($title);
        $count = static::where('slug', 'LIKE', $slug . '%')->count();
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }
}
