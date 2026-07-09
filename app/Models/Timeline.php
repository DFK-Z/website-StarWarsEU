<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'year_start',
        'year_end',
        'era',
        'author',
        'publisher',
        'description',
        'image',
    ];

    protected $table = 'timeline';

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&background=4A9EFF&color=0B0D10&size=200&font-size=0.3';
    }

    /**
     * Получить тип с эмодзи
     */
    public function getTypeEmojiAttribute(): string
    {
        return [
            'novel' => '📖',
            'comic' => '📚',
            'movie' => '🎬',
            'game' => '🎮',
            'other' => '📌',
        ][$this->type] ?? '📌';
    }

    /**
     * Получить цвет для типа
     */
    public function getTypeColorAttribute(): string
    {
        return [
            'novel' => 'bg-green-500',
            'comic' => 'bg-red-500',
            'movie' => 'bg-yellow-500',
            'game' => 'bg-purple-500',
            'other' => 'bg-gray-500',
        ][$this->type] ?? 'bg-gray-500';
    }
}
