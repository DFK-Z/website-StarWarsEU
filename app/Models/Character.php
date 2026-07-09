<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'lightsaber_color',
        'alias_lightsaber_color', // <-- НОВОЕ ПОЛЕ
        'slug',
        'image',
        'planet',
        'birth_year',
        'death_year',
        'race',
        'gender',
        'description',
        'quotes',
    ];

    protected $casts = [
        'quotes' => 'array',
    ];

    /**
     * Получить возраст персонажа
     */
    public function getAgeAttribute(): ?string
    {
        if ($this->birth_year && $this->death_year) {
            return ($this->death_year - $this->birth_year) . ' лет';
        }
        if ($this->birth_year) {
            return 'Родился в ' . abs($this->birth_year) . ' ДБЯ';
        }
        return null;
    }

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4A9EFF&color=0B0D10&size=200&font-size=0.4';
    }

    /**
     * Создать slug из имени
     */
    public static function generateSlug(string $name): string
    {
        $slug = \Str::slug($name);
        $count = static::where('slug', 'LIKE', $slug . '%')->count();
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }

    /**
     * Получить CSS-класс для цвета имени
     */
    public function getLightsaberTextClassAttribute(): string
    {
        $colors = [
            'blue' => 'text-lightsaber-blue',
            'green' => 'text-lightsaber-green',
            'red' => 'text-lightsaber-red',
            'purple' => 'text-lightsaber-purple',
            'yellow' => 'text-lightsaber-yellow',
            'orange' => 'text-lightsaber-orange',
            'white' => 'text-lightsaber-white',
            'black' => 'text-lightsaber-black',
            'pink' => 'text-lightsaber-pink',
            'cyan' => 'text-lightsaber-cyan',
            'gold' => 'text-lightsaber-gold',
        ];

        return $colors[$this->lightsaber_color] ?? '';
    }

    /**
     * Получить CSS-класс для цвета алиаса
     */
    public function getAliasLightsaberTextClassAttribute(): string
    {
        $colors = [
            'blue' => 'text-lightsaber-blue',
            'green' => 'text-lightsaber-green',
            'red' => 'text-lightsaber-red',
            'purple' => 'text-lightsaber-purple',
            'yellow' => 'text-lightsaber-yellow',
            'orange' => 'text-lightsaber-orange',
            'white' => 'text-lightsaber-white',
            'black' => 'text-lightsaber-black',
            'pink' => 'text-lightsaber-pink',
            'cyan' => 'text-lightsaber-cyan',
            'gold' => 'text-lightsaber-gold',
        ];

        // Если цвет для алиаса не выбран, используем цвет имени
        $color = $this->alias_lightsaber_color ?? $this->lightsaber_color;
        return $colors[$color] ?? '';
    }

    /**
     * Получить CSS-класс для точки алиаса
     */
    public function getAliasLightsaberClassAttribute(): string
    {
        $colors = [
            'blue' => 'lightsaber-blue',
            'green' => 'lightsaber-green',
            'red' => 'lightsaber-red',
            'purple' => 'lightsaber-purple',
            'yellow' => 'lightsaber-yellow',
            'orange' => 'lightsaber-orange',
            'white' => 'lightsaber-white',
            'black' => 'lightsaber-black',
            'pink' => 'lightsaber-pink',
            'cyan' => 'lightsaber-cyan',
            'gold' => 'lightsaber-gold',
        ];

        $color = $this->alias_lightsaber_color ?? $this->lightsaber_color;
        return $colors[$color] ?? '';
    }

    /**
     * Получить CSS-класс для точки имени
     */
    public function getLightsaberClassAttribute(): string
    {
        $colors = [
            'blue' => 'lightsaber-blue',
            'green' => 'lightsaber-green',
            'red' => 'lightsaber-red',
            'purple' => 'lightsaber-purple',
            'yellow' => 'lightsaber-yellow',
            'orange' => 'lightsaber-orange',
            'white' => 'lightsaber-white',
            'black' => 'lightsaber-black',
            'pink' => 'lightsaber-pink',
            'cyan' => 'lightsaber-cyan',
            'gold' => 'lightsaber-gold',
        ];

        return $colors[$this->lightsaber_color] ?? '';
    }

    /**
     * Получить отображаемое название цвета имени
     */
    public function getLightsaberColorDisplayAttribute(): string
    {
        $colors = [
            'blue' => 'Синий',
            'green' => 'Зелёный',
            'red' => 'Красный',
            'purple' => 'Фиолетовый',
            'yellow' => 'Жёлтый',
            'orange' => 'Оранжевый',
            'white' => 'Белый',
            'black' => 'Чёрный',
            'pink' => 'Розовый',
            'cyan' => 'Голубой',
            'gold' => 'Золотой',
        ];

        return $colors[$this->lightsaber_color] ?? 'Не выбран';
    }

    /**
     * Получить отображаемое название цвета алиаса
     */
    public function getAliasLightsaberColorDisplayAttribute(): string
    {
        $colors = [
            'blue' => 'Синий',
            'green' => 'Зелёный',
            'red' => 'Красный',
            'purple' => 'Фиолетовый',
            'yellow' => 'Жёлтый',
            'orange' => 'Оранжевый',
            'white' => 'Белый',
            'black' => 'Чёрный',
            'pink' => 'Розовый',
            'cyan' => 'Голубой',
            'gold' => 'Золотой',
        ];

        $color = $this->alias_lightsaber_color ?? $this->lightsaber_color;
        return $colors[$color] ?? 'Не выбран';
    }
}
