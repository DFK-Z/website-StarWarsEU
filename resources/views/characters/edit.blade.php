@extends('layouts.app')

@section('title', 'Редактировать персонажа — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/character.css') }}">
@endpush

@section('content')
<div class="character-form">
    <div class="character-form-header">
        <h1>✏️ Редактировать: {{ $character->name }}</h1>
        <a href="{{ route('characters.index') }}" class="back-link">← Назад</a>
    </div>

    <form method="POST" action="{{ route('characters.update', $character) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Имя -->
            <div class="form-group">
                <label for="name" class="form-label">Имя <span class="required">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name', $character->name) }}" class="form-input" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Он же (Alias) -->
            <div class="form-group">
                <label for="alias" class="form-label">Он же (Alias)</label>
                <input id="alias" type="text" name="alias" value="{{ old('alias', $character->alias) }}" class="form-input" placeholder="Например: Дарт Вейдер">
                @error('alias') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Другое имя персонажа, если есть. Оставьте пустым, если нет.</div>
            </div>

            <!-- Цвет для имени -->
            <div class="form-group">
                <label for="lightsaber_color" class="form-label">Цвет светового меча <span class="form-hint">(для имени)</span></label>
                <select id="lightsaber_color" name="lightsaber_color" class="form-input">
                    <option value="">Не выбран</option>
                    <option value="blue" {{ old('lightsaber_color', $character->lightsaber_color) == 'blue' ? 'selected' : '' }}>🔵 Синий</option>
                    <option value="green" {{ old('lightsaber_color', $character->lightsaber_color) == 'green' ? 'selected' : '' }}>🟢 Зелёный</option>
                    <option value="red" {{ old('lightsaber_color', $character->lightsaber_color) == 'red' ? 'selected' : '' }}>🔴 Красный</option>
                    <option value="purple" {{ old('lightsaber_color', $character->lightsaber_color) == 'purple' ? 'selected' : '' }}>🟣 Фиолетовый</option>
                    <option value="yellow" {{ old('lightsaber_color', $character->lightsaber_color) == 'yellow' ? 'selected' : '' }}>🟡 Жёлтый</option>
                    <option value="orange" {{ old('lightsaber_color', $character->lightsaber_color) == 'orange' ? 'selected' : '' }}>🟠 Оранжевый</option>
                    <option value="white" {{ old('lightsaber_color', $character->lightsaber_color) == 'white' ? 'selected' : '' }}>⚪ Белый</option>
                    <option value="black" {{ old('lightsaber_color', $character->lightsaber_color) == 'black' ? 'selected' : '' }}>⚫ Чёрный</option>
                    <option value="pink" {{ old('lightsaber_color', $character->lightsaber_color) == 'pink' ? 'selected' : '' }}>🩷 Розовый</option>
                    <option value="cyan" {{ old('lightsaber_color', $character->lightsaber_color) == 'cyan' ? 'selected' : '' }}>🩵 Голубой</option>
                    <option value="gold" {{ old('lightsaber_color', $character->lightsaber_color) == 'gold' ? 'selected' : '' }}>🌟 Золотой</option>
                </select>
                @error('lightsaber_color') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Этот цвет будет применён к основному имени персонажа.</div>
            </div>

            <!-- Цвет для алиаса -->
            <div class="form-group">
                <label for="alias_lightsaber_color" class="form-label">Цвет для «Он же» <span class="form-hint">(кликухи)</span></label>
                <select id="alias_lightsaber_color" name="alias_lightsaber_color" class="form-input">
                    <option value="">Использовать цвет имени</option>
                    <option value="blue" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'blue' ? 'selected' : '' }}>🔵 Синий</option>
                    <option value="green" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'green' ? 'selected' : '' }}>🟢 Зелёный</option>
                    <option value="red" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'red' ? 'selected' : '' }}>🔴 Красный</option>
                    <option value="purple" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'purple' ? 'selected' : '' }}>🟣 Фиолетовый</option>
                    <option value="yellow" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'yellow' ? 'selected' : '' }}>🟡 Жёлтый</option>
                    <option value="orange" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'orange' ? 'selected' : '' }}>🟠 Оранжевый</option>
                    <option value="white" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'white' ? 'selected' : '' }}>⚪ Белый</option>
                    <option value="black" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'black' ? 'selected' : '' }}>⚫ Чёрный</option>
                    <option value="pink" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'pink' ? 'selected' : '' }}>🩷 Розовый</option>
                    <option value="cyan" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'cyan' ? 'selected' : '' }}>🩵 Голубой</option>
                    <option value="gold" {{ old('alias_lightsaber_color', $character->alias_lightsaber_color) == 'gold' ? 'selected' : '' }}>🌟 Золотой</option>
                </select>
                @error('alias_lightsaber_color') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Выберите цвет для алиаса. Оставьте пустым, чтобы использовать цвет имени.</div>
            </div>

            <!-- Планета -->
            <div class="form-group">
                <label for="planet" class="form-label">Планета</label>
                <input id="planet" type="text" name="planet" value="{{ old('planet', $character->planet) }}" class="form-input">
                @error('planet') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Год рождения -->
            <div class="form-group">
                <label for="birth_year" class="form-label">Год рождения</label>
                <input id="birth_year" type="number" name="birth_year" value="{{ old('birth_year', $character->birth_year) }}" class="form-input" placeholder="Например: -32 (32 ДБЯ)">
                @error('birth_year') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Отрицательные числа = ДБЯ (До Битвы при Явине)</div>
            </div>

            <!-- Год смерти -->
            <div class="form-group">
                <label for="death_year" class="form-label">Год смерти</label>
                <input id="death_year" type="number" name="death_year" value="{{ old('death_year', $character->death_year) }}" class="form-input" placeholder="Оставьте пустым, если жив">
                @error('death_year') <p class="form-error">{{ $message }}</p> @enderror
                <div class="form-hint">💡 Положительные числа = ПБЯ (После Битвы при Явине)</div>
            </div>

            <!-- Раса -->
            <div class="form-group">
                <label for="race" class="form-label">Раса</label>
                <input id="race" type="text" name="race" value="{{ old('race', $character->race) }}" class="form-input">
                @error('race') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Гендер -->
            <div class="form-group">
                <label for="gender" class="form-label">Гендер</label>
                <select id="gender" name="gender" class="form-input">
                    <option value="">Не указано</option>
                    <option value="Мужской" {{ old('gender', $character->gender) == 'Мужской' ? 'selected' : '' }}>Мужской</option>
                    <option value="Женский" {{ old('gender', $character->gender) == 'Женский' ? 'selected' : '' }}>Женский</option>
                    <option value="Небинарный" {{ old('gender', $character->gender) == 'Небинарный' ? 'selected' : '' }}>Небинарный</option>
                </select>
                @error('gender') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Текущее изображение -->
        <div class="form-group">
            <label class="form-label">Текущее изображение</label>
            <div style="display:flex;align-items:center;gap:1rem;">
                <img src="{{ $character->image_url }}" alt="{{ $character->name }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid rgba(74,158,255,0.2);">
                <span style="font-size:0.875rem;color:var(--text-secondary);">
                    @if($character->image)
                        Загружено
                    @else
                        Стандартное изображение
                    @endif
                </span>
            </div>
        </div>

        <!-- Новое изображение -->
        <div class="form-group">
            <label for="image" class="form-label">Новое изображение</label>
            <input id="image" type="file" name="image" class="form-input-file" accept="image/*">
            @error('image') <p class="form-error">{{ $message }}</p> @enderror
            <div class="form-hint">📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB</div>
        </div>

        <!-- Описание -->
        <div class="form-group">
            <label for="description" class="form-label">Описание</label>
            <textarea id="description" name="description" rows="6" class="form-input">{{ old('description', $character->description) }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <!-- Цитаты -->
        <div class="form-group">
            <label class="form-label">Цитаты</label>
            <div id="quotes-container">
                @foreach(old('quotes', $character->quotes ?? []) as $quote)
                    @if(trim($quote))
                        <div class="quote-input-group">
                            <input type="text" name="quotes[]" value="{{ $quote }}" class="form-input" placeholder="Введите цитату">
                            <button type="button" class="btn-remove-quote" onclick="this.parentElement.remove()">✕</button>
                        </div>
                    @endif
                @endforeach
                <div class="quote-input-group">
                    <input type="text" name="quotes[]" class="form-input" placeholder="Введите цитату">
                    <button type="button" class="btn-remove-quote" onclick="this.parentElement.remove()" style="display:none;">✕</button>
                </div>
            </div>
            <button type="button" class="btn-add-quote" onclick="addQuoteField()">➕ Добавить цитату</button>
            <div class="form-hint">💡 Добавьте цитаты персонажа. Каждая цитата будет отображаться отдельно.</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">💾 Обновить</button>
            <a href="{{ route('characters.index') }}" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>

<script>
    function addQuoteField() {
        const container = document.getElementById('quotes-container');
        const lastGroup = container.querySelector('.quote-input-group:last-child');
        const newGroup = document.createElement('div');
        newGroup.className = 'quote-input-group';
        newGroup.innerHTML = `
            <input type="text" name="quotes[]" class="form-input" placeholder="Введите цитату">
            <button type="button" class="btn-remove-quote" onclick="this.parentElement.remove()">✕</button>
        `;
        container.appendChild(newGroup);
        if (lastGroup.querySelector('.btn-remove-quote')) {
            lastGroup.querySelector('.btn-remove-quote').style.display = 'flex';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('quotes-container');
        const groups = container.querySelectorAll('.quote-input-group');
        if (groups.length === 1 && !groups[0].querySelector('input').value.trim()) {
            groups[0].querySelector('.btn-remove-quote').style.display = 'none';
        }
    });
</script>
@endsection
