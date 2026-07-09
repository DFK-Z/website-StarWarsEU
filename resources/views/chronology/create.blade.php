@extends('layouts.app')

@section('title', 'Добавить событие в хронологию — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chronology.css') }}">
    <style>
        .form-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
    </style>
@endpush

@section('content')
<div class="chronology-form">
    <div class="chronology-form-header">
        <h1>➕ Добавить событие в хронологию</h1>
        <a href="{{ route('chronology.index') }}" class="back-link">← Назад</a>
    </div>

    <form method="POST" action="{{ route('chronology.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <!-- Название -->
            <div class="form-group">
                <label for="title" class="form-label">Название <span class="required">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="Например: Траунская трилогия" required>
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Тип -->
            <div class="form-group">
                <label for="type" class="form-label">Тип <span class="required">*</span></label>
                <select id="type" name="type" class="form-input">
                    <option value="novel" {{ old('type') == 'novel' ? 'selected' : '' }}>📖 Роман</option>
                    <option value="comic" {{ old('type') == 'comic' ? 'selected' : '' }}>📚 Комикс</option>
                    <option value="movie" {{ old('type') == 'movie' ? 'selected' : '' }}>🎬 Фильм</option>
                    <option value="game" {{ old('type') == 'game' ? 'selected' : '' }}>🎮 Игра</option>
                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>📌 Другое</option>
                </select>
                @error('type') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Год начала -->
            <div class="form-group">
                <label for="year_start" class="form-label">Год начала <span class="required">*</span></label>
                <input id="year_start" type="number" name="year_start" value="{{ old('year_start') }}" class="form-input" placeholder="Например: -5 (5 ДБЯ)" required>
                @error('year_start') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Отрицательные числа = ДБЯ (До Битвы при Явине)</div>
            </div>

            <!-- Год конца -->
            <div class="form-group">
                <label for="year_end" class="form-label">Год конца</label>
                <input id="year_end" type="number" name="year_end" value="{{ old('year_end') }}" class="form-input" placeholder="Оставьте пустым, если одно событие">
                @error('year_end') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Положительные числа = ПБЯ (После Битвы при Явине)</div>
            </div>

            <!-- Эра -->
            <div class="form-group">
                <label for="era" class="form-label">Эра</label>
                <input id="era" type="text" name="era" value="{{ old('era') }}" class="form-input" placeholder="Например: Старая Республика, Империя">
                @error('era') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Автор -->
            <div class="form-group">
                <label for="author" class="form-label">Автор</label>
                <input id="author" type="text" name="author" value="{{ old('author') }}" class="form-input" placeholder="Например: Тимоти Зан">
                @error('author') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Издатель -->
            <div class="form-group">
                <label for="publisher" class="form-label">Издатель</label>
                <input id="publisher" type="text" name="publisher" value="{{ old('publisher') }}" class="form-input" placeholder="Например: Bantam Spectra">
                @error('publisher') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Изображение -->
            <div class="form-group full-width">
                <label for="image" class="form-label">Изображение</label>
                <input id="image" type="file" name="image" class="form-input-file" accept="image/*">
                @error('image') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB</div>
            </div>
        </div>

        <!-- Описание -->
        <div class="form-group">
            <label for="description" class="form-label">Описание</label>
            <textarea id="description" name="description" rows="6" class="form-input" placeholder="Введите описание события...">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Сохранить</button>
            <a href="{{ route('chronology.index') }}" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>
@endsection
