@extends('layouts.app')

@section('title', 'Результаты поиска: ' . $query . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@section('content')
<div class="search-container">
    <div class="search-header">
        <h1>🔍 Результаты поиска</h1>
        <p>По запросу: <strong>"{{ $query }}"</strong></p>
    </div>

    @if($characters->isEmpty() && $timeline->isEmpty())
        <div class="empty-state">
            <span class="empty-icon">🔭</span>
            <p>Ничего не найдено по запросу "{{ $query }}"</p>
            <p style="font-size:0.875rem;color:var(--text-muted);">
                Попробуйте изменить запрос или проверьте написание
            </p>
        </div>
    @else
        <!-- Персонажи -->
        @if($characters->isNotEmpty())
            <div class="search-section">
                <h2>👤 Персонажи</h2>
                <div class="search-results-grid">
                    @foreach($characters as $character)
                        <a href="{{ route('characters.show', $character) }}" class="search-result-item">
                            <img src="{{ $character->image_url }}" alt="{{ $character->name }}" class="search-result-image">
                            <div class="search-result-info">
                                <h3>{{ $character->name }}</h3>
                                @if($character->alias)
                                    <span class="search-result-alias">{{ $character->alias }}</span>
                                @endif
                                <span class="search-result-type">Персонаж</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Хронология -->
        @if($timeline->isNotEmpty())
            <div class="search-section">
                <h2>📜 Хронология</h2>
                <div class="search-results-grid">
                    @foreach($timeline as $item)
                        <a href="{{ route('timeline.show', $item) }}" class="search-result-item">
                            <div class="search-result-icon" style="background:{{ $item->type_color }}20; border-color:{{ $item->type_color }};">
                                <span style="font-size:1.5rem;">{{ $item->type_emoji }}</span>
                            </div>
                            <div class="search-result-info">
                                <h3>{{ $item->title }}</h3>
                                <span class="search-result-year">{{ $item->year < 0 ? abs($item->year) . ' ДБЯ' : $item->year . ' ПБЯ' }}</span>
                                <span class="search-result-type">{{ $item->type_name }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
