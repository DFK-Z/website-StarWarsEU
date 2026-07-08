<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    /**
     * Получить URL аватарки
     */
    public function getAvatarUrlAttribute(): string
    {
        $avatar = $this->getFirstMedia('avatar');
        if ($avatar) {
            return $avatar->getUrl('thumb');
        }
        // Дефолтная аватарка (UI Avatars)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4A9EFF&color=0B0D10&size=100&font-size=0.5';
    }

    /**
     * Регистрируем коллекции медиа
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(200)
                    ->height(200)
                    ->sharpen(10)
                    ->nonQueued();
            });
    }
}
