@extends('layouts.app')

@section('title', 'Добавить событие — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
@endpush

@section('content')
<div class="timeline-form">
    <div class="timeline-form-header">
        <h1>➕ Добавить событие</h1>
        <a href="{{ route('timeline.index') }}" class="back-link">← Назад</a>
    </div>

    <form method="POST" action="{{ route('timeline.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <!-- Название -->
            <div class="form-group">
                <label for="title" class="form-label">Название <span class="required">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="Например: Битва при Явине" required>
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Год -->
            <div class="form-group">
                <label for="year" class="form-label">Год <span class="required">*</span></label>
                <input id="year" type="number" name="year" value="{{ old('year') }}" class="form-input" placeholder="Например: -32 (32 ДБЯ)" required>
                @error('year') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Отрицательные числа = ДБЯ (До Битвы при Явине), положительные = ПБЯ</div>
            </div>

            <!-- Тип -->
            <div class="form-group">
                <label for="type" class="form-label">Тип <span class="required">*</span></label>
                <select id="type" name="type" class="form-input" required>
                    <option value="">Выберите тип</option>
                    <option value="novel" {{ old('type') == 'novel' ? 'selected' : '' }}>📖 Роман</option>
                    <option value="comic" {{ old('type') == 'comic' ? 'selected' : '' }}>📚 Комикс</option>
                    <option value="movie" {{ old('type') == 'movie' ? 'selected' : '' }}>🎬 Фильм</option>
                    <option value="game" {{ old('type') == 'game' ? 'selected' : '' }}>🎮 Игра</option>
                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>⚔️ Событие</option>
                </select>
                @error('type') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Выберите тип события</div>
            </div>

            <!-- Изображение -->
            <div class="form-group">
                <label for="image" class="form-label">Изображение</label>
                <input id="image" type="file" name="image" class="form-input-file" accept="image/*">
                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB</div>
            </div>
        </div>

        <!-- Описание -->
        <div class="form-group">
            <label for="description" class="form-label">Описание</label>
            <textarea id="description" name="description" rows="6" class="form-input" placeholder="Введите подробное описание события...">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Сохранить</button>
            <a href="{{ route('timeline.index') }}" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>
@endsection
