@extends('layouts.app')

@section('title', $timeline->title . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@endpush

@section('content')
<div class="timeline-detail">
    <div class="timeline-detail-header">
        <a href="{{ route('timeline.index') }}" class="back-link">← Назад к хронологии</a>
        @auth
            <div class="timeline-detail-actions">
                <a href="{{ route('timeline.edit', $timeline) }}" class="btn-edit">✏️ Редактировать</a>
                <form method="POST" action="{{ route('timeline.destroy', $timeline) }}"
                      style="display:inline;"
                      onsubmit="return confirm('Вы уверены, что хотите удалить это событие?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">🗑️ Удалить</button>
                </form>
            </div>
        @endauth
    </div>

    <div class="timeline-detail-grid">
        <div class="timeline-detail-image">
            @if($timeline->image)
                <img src="{{ $timeline->image_url }}" alt="{{ $timeline->title }}">
            @else
                <div class="timeline-detail-placeholder" style="background: {{ $timeline->type_color }}20; border: 2px solid {{ $timeline->type_color }};">
                    <span style="font-size:4rem;">{{ $timeline->type_emoji }}</span>
                </div>
            @endif
        </div>

        <div class="timeline-detail-info">
            <div class="timeline-detail-badge" style="background: {{ $timeline->type_color }}20; color: {{ $timeline->type_color }}; border: 1px solid {{ $timeline->type_color }}30;">
                {{ $timeline->type_emoji }} {{ $timeline->type_name }}
            </div>

            <h1>{{ $timeline->title }}</h1>

            <div class="timeline-detail-year">
                <span class="year-badge">
                    📅 {{ $timeline->year < 0 ? abs($timeline->year) . ' ДБЯ' : $timeline->year . ' ПБЯ' }}
                </span>
            </div>

            @if($timeline->description)
                <div class="timeline-detail-description">
                    <h2>📖 Описание</h2>
                    <div class="description-content">
                        {!! nl2br(e($timeline->description)) !!}
                    </div>
                </div>
            @endif

            <div class="timeline-detail-meta">
                <div class="meta-item">
                    <span class="meta-label">🆔 ID</span>
                    <span class="meta-value">#{{ $timeline->id }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">📅 Создано</span>
                    <span class="meta-value">{{ $timeline->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">🔄 Обновлено</span>
                    <span class="meta-value">{{ $timeline->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
