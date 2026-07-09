@extends('layouts.app')

@section('title', 'Персонажи — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/character.css') }}">
@endpush

@section('content')
<div class="character-container">
    <div class="character-header">
        <div class="character-header-content">
            <h1>👤 Персонажи</h1>
            <p>Хранители знаний о героях далёкой-далёкой галактики</p>
        </div>
        @auth
            <a href="{{ route('characters.create') }}" class="btn-create">
                <span>➕</span> Добавить персонажа
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="characters-grid">
        @forelse($characters as $character)
            <a href="{{ route('characters.show', $character) }}" class="character-card">
                <div class="character-card-image">
                    <img src="{{ $character->image_url }}" alt="{{ $character->name }}">
                </div>
                <div class="character-card-info">
                    <h3>
                        <span class="{{ $character->lightsaber_text_class }}">
                            {{ $character->name }}
                        </span>
                        @if($character->lightsaber_color)
                            <span class="lightsaber-dot {{ $character->lightsaber_class }}"></span>
                        @endif
                    </h3>

                    @if($character->alias)
                        <div class="character-card-alias">
                            <span class="alias-badge">он же</span>
                            <span class="alias-text {{ $character->alias_lightsaber_text_class }}">
                                {{ $character->alias }}
                            </span>
                            @if($character->alias_lightsaber_color && $character->alias_lightsaber_color != $character->lightsaber_color)
                                <span class="lightsaber-dot {{ $character->alias_lightsaber_class }}" style="width:10px;height:10px;"></span>
                            @endif
                        </div>
                    @endif

                    <span class="character-card-race">{{ $character->race ?: 'Неизвестно' }}</span>
                    @if($character->planet)
                        <span class="character-card-planet">🌍 {{ $character->planet }}</span>
                    @endif
                </div>
                <div class="character-card-footer">
                    @auth
                        <a href="{{ route('characters.edit', $character) }}" class="btn-edit">✏️</a>
                        <form method="POST" action="{{ route('characters.destroy', $character) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Вы уверены, что хотите удалить этого персонажа?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">🗑️</button>
                        </form>
                    @endauth
                </div>
            </a>
        @empty
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p>Персонажей пока нет</p>
                @auth
                    <a href="{{ route('characters.create') }}" class="btn-create-empty">Добавить первого персонажа</a>
                @endauth
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $characters->links() }}
    </div>
</div>
@endsection
