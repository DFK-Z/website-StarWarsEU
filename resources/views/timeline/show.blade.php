@extends('layouts.app')

@section('title', $timeline->title . ' — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
    <style>
        .timeline-detail {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .timeline-detail-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link:hover {
            color: var(--text-primary);
        }

        .timeline-detail-actions {
            display: flex;
            gap: 0.75rem;
        }

        .timeline-detail-actions .btn-edit,
        .timeline-detail-actions .btn-delete {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .timeline-detail-actions .btn-edit {
            background: rgba(74, 158, 255, 0.12);
            color: #4A9EFF;
        }

        .timeline-detail-actions .btn-edit:hover {
            background: rgba(74, 158, 255, 0.2);
        }

        .timeline-detail-actions .btn-delete {
            background: rgba(224, 74, 95, 0.12);
            color: #E04A5F;
        }

        .timeline-detail-actions .btn-delete:hover {
            background: rgba(224, 74, 95, 0.2);
        }

        .timeline-detail-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2.5rem;
            margin-bottom: 2.5rem;
        }

        @media (max-width: 768px) {
            .timeline-detail-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        .timeline-detail-image {
            border-radius: 1rem;
            overflow: hidden;
            background: rgba(27, 32, 40, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .timeline-detail-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .timeline-detail-info h1 {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .timeline-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .timeline-detail-meta .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .timeline-detail-meta .meta-item .year {
            font-weight: 700;
            color: #4A9EFF;
        }

        .timeline-detail-meta .meta-item .type-badge {
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .timeline-detail-meta .meta-item .type-badge.novel {
            background: rgba(57, 255, 20, 0.12);
            color: #39FF14;
            border: 1px solid rgba(57, 255, 20, 0.15);
        }

        .timeline-detail-meta .meta-item .type-badge.comic {
            background: rgba(255, 23, 68, 0.12);
            color: #FF1744;
            border: 1px solid rgba(255, 23, 68, 0.15);
        }

        .timeline-detail-meta .meta-item .type-badge.game {
            background: rgba(245, 176, 65, 0.12);
            color: #F5B041;
            border: 1px solid rgba(245, 176, 65, 0.15);
        }

        .timeline-detail-meta .meta-item .type-badge.movie {
            background: rgba(74, 158, 255, 0.12);
            color: #4A9EFF;
            border: 1px solid rgba(74, 158, 255, 0.15);
        }

        .timeline-detail-meta .meta-item .type-badge.general {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .timeline-detail-related {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .timeline-detail-related .related-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            background: rgba(74, 158, 255, 0.06);
            border: 1px solid rgba(74, 158, 255, 0.08);
            border-radius: 0.5rem;
            color: #4A9EFF;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .timeline-detail-related .related-link:hover {
            background: rgba(74, 158, 255, 0.12);
            border-color: rgba(74, 158, 255, 0.15);
        }

        .timeline-detail-description {
            margin-top: 2.5rem;
        }

        .timeline-detail-description h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .description-content {
            background: rgba(27, 32, 40, 0.3);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 0.9375rem;
        }
    </style>
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
            <img src="{{ $timeline->image_url }}" alt="{{ $timeline->title }}">
        </div>

        <div class="timeline-detail-info">
            <h1>{{ $timeline->title }}</h1>

            <div class="timeline-detail-meta">
                <div class="meta-item">
                    📅 <span class="year">{{ $timeline->year_display }}</span>
                </div>
                <div class="meta-item">
                    <span class="type-badge {{ $timeline->type }}">
                        {{ $timeline->type_label }}
                    </span>
                </div>
            </div>

            @if($timeline->character || $timeline->planet)
                <div class="timeline-detail-related">
                    @if($timeline->character)
                        <a href="{{ route('characters.show', $timeline->character) }}" class="related-link">
                            👤 {{ $timeline->character->name }}
                        </a>
                    @endif
                    @if($timeline->planet)
                        <a href="#" class="related-link">
                            🌍 {{ $timeline->planet->name }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if($timeline->description)
        <div class="timeline-detail-description">
            <h2>📖 Описание</h2>
            <div class="description-content">
                {!! nl2br(e($timeline->description)) !!}
            </div>
        </div>
    @endif
</div>
@endsection
