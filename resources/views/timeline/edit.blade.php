@extends('layouts.app')

@section('title', 'Редактировать событие — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@endpush

@section('content')
<div class="timeline-form">
    <div class="timeline-form-header">
        <h1>✏️ Редактировать: {{ $timeline->title }}</h1>
        <a href="{{ route('timeline.index') }}" class="back-link">← Назад</a>
    </div>

    <form method="POST" action="{{ route('timeline.update', $timeline) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Название -->
            <div class="form-group">
                <label for="title" class="form-label">Название <span class="required">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $timeline->title) }}" class="form-input" required>
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Год -->
            <div class="form-group">
                <label for="year" class="form-label">Год <span class="required">*</span></label>
                <input id="year" type="number" name="year" value="{{ old('year', $timeline->year) }}" class="form-input" required>
                @error('year') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Отрицательные числа = ДБЯ (До Битвы при Явине), положительные = ПБЯ</div>
            </div>

            <!-- Тип -->
            <div class="form-group">
                <label for="type" class="form-label">Тип <span class="required">*</span></label>
                <select id="type" name="type" class="form-input" required>
                    <option value="">Выберите тип</option>
                    <option value="novel" {{ old('type', $timeline->type) == 'novel' ? 'selected' : '' }}>📖 Роман</option>
                    <option value="comic" {{ old('type', $timeline->type) == 'comic' ? 'selected' : '' }}>📚 Комикс</option>
                    <option value="movie" {{ old('type', $timeline->type) == 'movie' ? 'selected' : '' }}>🎬 Фильм</option>
                    <option value="game" {{ old('type', $timeline->type) == 'game' ? 'selected' : '' }}>🎮 Игра</option>
                    <option value="event" {{ old('type', $timeline->type) == 'event' ? 'selected' : '' }}>⚔️ Событие</option>
                </select>
                @error('type') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Выберите тип события</div>
            </div>

            <!-- Текущее изображение -->
            <div class="form-group">
                <label class="form-label">Текущее изображение</label>
                <div style="display:flex;align-items:center;gap:1rem;">
                    @if($timeline->image)
                        <img src="{{ $timeline->image_url }}" alt="{{ $timeline->title }}" style="width:80px;height:80px;object-fit:cover;border-radius:0.5rem;border:2px solid rgba(74,158,255,0.2);">
                        <span style="font-size:0.875rem;color:var(--text-secondary);">Загружено</span>
                    @else
                        <div style="width:80px;height:80px;border-radius:0.5rem;background:{{ $timeline->type_color }}20;border:2px solid {{ $timeline->type_color }};display:flex;align-items:center;justify-content:center;font-size:2rem;">
                            {{ $timeline->type_emoji }}
                        </div>
                        <span style="font-size:0.875rem;color:var(--text-secondary);">Нет изображения</span>
                    @endif
                </div>
            </div>

            <!-- Новое изображение -->
            <div class="form-group">
                <label for="image" class="form-label">Новое изображение</label>
                <input id="image" type="file" name="image" class="form-input-file" accept="image/*">
                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB</div>
            </div>
        </div>

        <!-- Описание -->
        <div class="form-group">
            <label for="description" class="form-label">Описание</label>
            <textarea id="description" name="description" rows="6" class="form-input">{{ old('description', $timeline->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Обновить</button>
            <a href="{{ route('timeline.index') }}" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>
@endsection
