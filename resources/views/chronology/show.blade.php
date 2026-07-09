@extends('layouts.app')

@section('title', $timeline->title . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chronology.css') }}">
@endpush

@section('content')
<div class="chronology-detail">
    <div class="chronology-detail-header">
        <a href="{{ route('chronology.index') }}" class="back-link">← Назад к хронологии</a>
        @auth
            <div class="chronology-detail-actions">
                <a href="{{ route('chronology.edit', $timeline) }}" class="btn-edit">✏️ Редактировать</a>
                <form method="POST" action="{{ route('chronology.destroy', $timeline) }}"
                      style="display:inline;"
                      onsubmit="return confirm('Вы уверены, что хотите удалить это событие?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">🗑️ Удалить</button>
                </form>
            </div>
        @endauth
    </div>

    <div class="chronology-detail-grid">
        <div class="chronology-detail-image">
            <img src="{{ $timeline->image_url }}" alt="{{ $timeline->title }}">
            <div class="chronology-detail-type-badge">
                <span class="type-badge {{ $timeline->type }}">
                    {{ $timeline->type_emoji }} {{ ucfirst($timeline->type) }}
                </span>
            </div>
        </div>

        <div class="chronology-detail-info">
            <h1>{{ $timeline->title }}</h1>

            <div class="chronology-detail-years">
                <span class="year-badge">
                    📅 {{ $timeline->year_start < 0 ? abs($timeline->year_start) . ' ДБЯ' : $timeline->year_start . ' ПБЯ' }}
                    @if($timeline->year_end)
                        – {{ $timeline->year_end < 0 ? abs($timeline->year_end) . ' ДБЯ' : $timeline->year_end . ' ПБЯ' }}
                    @endif
                </span>
            </div>

            <div class="chronology-detail-stats">
                @if($timeline->era)
                    <div class="stat-item">
                        <span class="stat-label">🏷️ Эра</span>
                        <span class="stat-value">{{ $timeline->era }}</span>
                    </div>
                @endif
                @if($timeline->author)
                    <div class="stat-item">
                        <span class="stat-label">✍️ Автор</span>
                        <span class="stat-value">{{ $timeline->author }}</span>
                    </div>
                @endif
                @if($timeline->publisher)
                    <div class="stat-item">
                        <span class="stat-label">🏢 Издатель</span>
                        <span class="stat-value">{{ $timeline->publisher }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($timeline->description)
        <div class="chronology-detail-description">
            <h2>📖 Описание</h2>
            <div class="description-content">
                {!! nl2br(e($timeline->description)) !!}
            </div>
        </div>
    @endif
</div>
@endsection
