@extends('layouts.app')

@section('title', $character->name . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/character.css') }}">
@endpush

@section('content')
<div class="character-detail">
    <div class="character-detail-header">
        <a href="{{ route('characters.index') }}" class="back-link">← Назад к персонажам</a>
        @auth
            <div class="character-detail-actions">
                <a href="{{ route('characters.edit', $character) }}" class="btn-edit">✏️ Редактировать</a>
                <form method="POST" action="{{ route('characters.destroy', $character) }}"
                      style="display:inline;"
                      onsubmit="return confirm('Вы уверены, что хотите удалить этого персонажа?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">🗑️ Удалить</button>
                </form>
            </div>
        @endauth
    </div>

    <div class="character-detail-grid">
        <div class="character-detail-image">
            <img src="{{ $character->image_url }}" alt="{{ $character->name }}">
        </div>

        <div class="character-detail-info">
            <h1>
                <span class="{{ $character->lightsaber_text_class }}">
                    {{ $character->name }}
                </span>
                @if($character->lightsaber_color)
                    <span class="lightsaber-detail {{ $character->lightsaber_class }}"></span>
                @endif
            </h1>

            @if($character->alias)
                <div class="character-detail-alias">
                    <span class="alias-label">Он же</span>
                    <span class="alias-value {{ $character->alias_lightsaber_text_class }}">
                        {{ $character->alias }}
                    </span>
                    @if($character->alias_lightsaber_color && $character->alias_lightsaber_color != $character->lightsaber_color)
                        <span class="lightsaber-detail {{ $character->alias_lightsaber_class }}" style="width:16px;height:16px;"></span>
                    @endif
                </div>
            @endif

            @if($character->age)
                <div class="character-detail-age">
                    <span class="badge-age">{{ $character->age }}</span>
                </div>
            @endif

            <div class="character-detail-stats">
                <div class="stat-item">
                    <span class="stat-label">🌍 Планета</span>
                    <span class="stat-value">{{ $character->planet ?: 'Неизвестно' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">📅 Год рождения</span>
                    <span class="stat-value">{{ $character->birth_year ? abs($character->birth_year) . ' ' . ($character->birth_year < 0 ? 'ДБЯ' : 'ПБЯ') : 'Неизвестно' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">💀 Год смерти</span>
                    <span class="stat-value">{{ $character->death_year ? abs($character->death_year) . ' ' . ($character->death_year < 0 ? 'ДБЯ' : 'ПБЯ') : 'Жив' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">🧬 Раса</span>
                    <span class="stat-value">{{ $character->race ?: 'Неизвестно' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">⚥ Гендер</span>
                    <span class="stat-value">{{ $character->gender ?: 'Неизвестно' }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($character->description)
        <div class="character-detail-description">
            <h2>📖 Описание</h2>
            <div class="description-content">
                {!! nl2br(e($character->description)) !!}
            </div>
        </div>
    @endif

    @if($character->quotes && count($character->quotes) > 0)
        <div class="character-detail-quotes">
            <h2>💬 Цитаты</h2>
            <div class="quotes-list">
                @foreach($character->quotes as $quote)
                    @if(trim($quote))
                        <div class="quote-item">
                            <span class="quote-mark">"</span>
                            {{ $quote }}
                            <span class="quote-mark">"</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
