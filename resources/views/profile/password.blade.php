@extends('layouts.app')

@section('title', 'Смена пароля — EU Holocron')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="profile-container">
    <aside class="profile-sidebar">
        <div class="profile-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар">
            @else
                {{ substr($user->name, 0, 1) }}
            @endif
        </div>
        <div class="profile-name">{{ $user->name }}</div>
        <div class="profile-email">{{ $user->email }}</div>
        <nav class="profile-sidebar-nav">
            <a href="{{ route('profile') }}">👤 Мой профиль</a>
            <a href="{{ route('profile.edit') }}">✏️ Редактировать</a>
            <a href="{{ route('profile.password') }}" class="active">🔑 Сменить пароль</a>
            <a href="/">🏠 На главную</a>
        </nav>
    </aside>

    <main class="profile-content">
        <h2>🔑 Смена пароля</h2>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password" class="form-label">Текущий пароль</label>
                <input id="current_password" type="password" name="current_password" class="form-input" placeholder="Введите текущий пароль" required>
                @error('current_password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password" class="form-label">Новый пароль</label>
                <input id="new_password" type="password" name="new_password" class="form-input" placeholder="Минимум 8 символов" required>
                @error('new_password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <div class="password-hint">💡 Пароль должен содержать минимум <code>8</code> символов</div>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation" class="form-label">Подтверждение нового пароля</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-input" placeholder="Повторите новый пароль" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">🔒 Сменить пароль</button>
                <a href="{{ route('profile') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </main>
</div>
@endsection
