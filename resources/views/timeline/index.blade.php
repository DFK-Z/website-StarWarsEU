@extends('layouts.app')

@section('title', 'Хронология — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@endpush

@section('content')
<div class="timeline-container">
    <div class="timeline-header">
        <div class="timeline-header-content">
            <h1>📜 Хронология</h1>
            <p>События расширенной вселенной в хронологическом порядке</p>
        </div>
        @auth
            <a href="{{ route('timeline.create') }}" class="btn-create">
                <span>➕</span> Добавить событие
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- Фильтры -->
    <div class="timeline-filters">
        <a href="{{ route('timeline.index') }}"
           class="filter-btn {{ $selectedType == 'all' ? 'active' : '' }}">
            🌟 Все
        </a>
        <a href="{{ route('timeline.index', ['type' => 'novel']) }}"
           class="filter-btn novel {{ $selectedType == 'novel' ? 'active' : '' }}">
            📖 Романы
        </a>
        <a href="{{ route('timeline.index', ['type' => 'comic']) }}"
           class="filter-btn comic {{ $selectedType == 'comic' ? 'active' : '' }}">
            📚 Комиксы
        </a>
        <a href="{{ route('timeline.index', ['type' => 'game']) }}"
           class="filter-btn game {{ $selectedType == 'game' ? 'active' : '' }}">
            🎮 Игры
        </a>
        <a href="{{ route('timeline.index', ['type' => 'movie']) }}"
           class="filter-btn movie {{ $selectedType == 'movie' ? 'active' : '' }}">
            🎬 Фильмы
        </a>
        <a href="{{ route('timeline.index', ['type' => 'general']) }}"
           class="filter-btn general {{ $selectedType == 'general' ? 'active' : '' }}">
            🌟 Общее
        </a>
    </div>

    <!-- Список событий -->
    <div class="timeline-list">
        @forelse($timelines as $timeline)
            <a href="{{ route('timeline.show', $timeline) }}" class="timeline-item">
                <div class="timeline-year">
                    {{ $timeline->year_display }}
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">
                        {{ $timeline->title }}
                        <span class="timeline-type {{ $timeline->type }}">
                            {{ $timeline->type_label }}
                        </span>
                    </div>
                    <div class="timeline-description">
                        {{ Str::limit($timeline->description, 150) }}
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p>Событий пока нет</p>
                @auth
                    <a href="{{ route('timeline.create') }}" class="btn-create-empty">Добавить первое событие</a>
                @endauth
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $timelines->links() }}
    </div>
</div>
@endsection
