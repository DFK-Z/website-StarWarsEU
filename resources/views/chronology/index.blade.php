@extends('layouts.app')

@section('title', 'Хронология — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chronology.css') }}">
@endpush

@section('content')
<div class="chronology-container">
    <div class="chronology-header">
        <div class="chronology-header-content">
            <h1>📅 Хронология</h1>
            <p>Вселенная «Звёздных войн» в хронологическом порядке</p>
        </div>
        @auth
            <a href="{{ route('chronology.create') }}" class="btn-create">
                <span>➕</span> Добавить событие
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- ===== ФИЛЬТРЫ ===== -->
    <div class="chronology-filters">
        <a href="{{ route('chronology.index', ['type' => 'all']) }}"
           class="filter-btn {{ $selectedType == 'all' ? 'active' : '' }}">
            Все
        </a>
        @foreach($types as $type)
            <a href="{{ route('chronology.index', ['type' => $type]) }}"
               class="filter-btn {{ $selectedType == $type ? 'active' : '' }}">
                {{ [
                    'novel' => '📖 Романы',
                    'comic' => '📚 Комиксы',
                    'movie' => '🎬 Фильмы',
                    'game' => '🎮 Игры',
                    'other' => '📌 Другое'
                ][$type] }}
            </a>
        @endforeach
    </div>

    <!-- ===== ТАЙМЛАЙН ===== -->
    <div class="timeline">
        @forelse($timeline as $item)
            <div class="timeline-item">
                <div class="timeline-item-marker">
                    <div class="timeline-item-dot"></div>
                    @if(!$loop->last)
                        <div class="timeline-item-line"></div>
                    @endif
                </div>
                <div class="timeline-item-content">
                    <a href="{{ route('chronology.show', $item) }}" class="chronology-card">
                        <div class="chronology-card-image">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        </div>
                        <div class="chronology-card-info">
                            <div class="chronology-card-type">
                                <span class="type-badge {{ $item->type }}">
                                    {{ $item->type_emoji }} {{ ucfirst($item->type) }}
                                </span>
                                <span class="chronology-card-year">
                                    {{ $item->year_start < 0 ? abs($item->year_start) . ' ДБЯ' : $item->year_start . ' ПБЯ' }}
                                    @if($item->year_end)
                                        – {{ $item->year_end < 0 ? abs($item->year_end) . ' ДБЯ' : $item->year_end . ' ПБЯ' }}
                                    @endif
                                </span>
                            </div>
                            <h3>{{ $item->title }}</h3>
                            @if($item->author)
                                <span class="chronology-card-author">✍️ {{ $item->author }}</span>
                            @endif
                            @if($item->era)
                                <span class="chronology-card-era">🏷️ {{ $item->era }}</span>
                            @endif
                            @if($item->description)
                                <p class="chronology-card-description">{{ Str::limit($item->description, 150) }}</p>
                            @endif
                        </div>
                        @auth
                            <div class="chronology-card-footer">
                                <a href="{{ route('chronology.edit', $item) }}" class="btn-edit">✏️</a>
                                <form method="POST" action="{{ route('chronology.destroy', $item) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить это событие?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑️</button>
                                </form>
                            </div>
                        @endauth
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p>Событий пока нет</p>
                @auth
                    <a href="{{ route('chronology.create') }}" class="btn-create-empty">Добавить первое событие</a>
                @endauth
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $timeline->appends(['type' => $selectedType])->links() }}
    </div>
</div>
@endsection
