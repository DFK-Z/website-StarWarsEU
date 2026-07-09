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
            <p>Хранители времени далёкой-далёкой галактики</p>
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

    <!-- Фильтрация -->
    <div class="timeline-filters">
        @foreach($types as $key => $label)
            <a href="{{ route('timeline.index', ['type' => $key]) }}"
               class="filter-btn {{ $currentType == $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Хронология -->
    <div class="timeline-list">
        @forelse($grouped as $year => $items)
            @php
                $yearInt = (int) $year;
            @endphp
            <div class="timeline-year-group">
                <div class="timeline-year">
                    <span class="year-label">
                        {{ $yearInt < 0 ? abs($yearInt) . ' ДБЯ' : $yearInt . ' ПБЯ' }}
                    </span>
                    <span class="year-line"></span>
                </div>
                <div class="timeline-items">
                    @foreach($items as $item)
                        <a href="{{ route('timeline.show', $item) }}" class="timeline-item" style="border-left-color: {{ $item->type_color }};">
                            <div class="timeline-item-icon">
                                <span style="color: {{ $item->type_color }};">{{ $item->type_emoji }}</span>
                            </div>
                            <div class="timeline-item-content">
                                <h3>{{ $item->title }}</h3>
                                <span class="timeline-item-type" style="color: {{ $item->type_color }};">
                                    {{ $item->type_name }}
                                </span>
                                @if($item->description)
                                    <p>{{ Str::limit($item->description, 120) }}</p>
                                @endif
                            </div>
                            @auth
                                <div class="timeline-item-actions">
                                    <a href="{{ route('timeline.edit', $item) }}" class="btn-edit">✏️</a>
                                    <form method="POST" action="{{ route('timeline.destroy', $item) }}"
                                          style="display:inline;"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить это событие?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️</button>
                                    </form>
                                </div>
                            @endauth
                        </a>
                    @endforeach
                </div>
            </div>
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
</div>
@endsection
