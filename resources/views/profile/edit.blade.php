@extends('layouts.app')

@section('title', 'Редактирование профиля — EU Holocron')

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
            <a href="{{ route('profile.edit') }}" class="active">✏️ Редактировать</a>
            <a href="{{ route('profile.password') }}">🔑 Сменить пароль</a>
            <a href="/">🏠 На главную</a>
        </nav>
    </aside>

    <main class="profile-content">
        <h2>✏️ Редактирование профиля</h2>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="avatar-preview">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар">
                @else
                    <div class="profile-avatar" style="width:64px;height:64px;font-size:1.5rem;margin:0;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div class="info">
                    <strong>Текущая аватарка</strong><br>
                    <span style="font-size:0.75rem;color:var(--text-muted);">
                        @if($user->avatar)
                            Загружена
                        @else
                            Используется стандартная аватарка
                        @endif
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="avatar" class="form-label">Новая аватарка</label>
                <input id="avatar" type="file" name="avatar" class="form-input-file" accept="image/*">
                @error('avatar')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.375rem;">
                    📸 Поддерживаются: JPG, PNG, GIF, WEBP. Максимальный размер: 2MB
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">💾 Сохранить</button>
                <a href="{{ route('profile') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.querySelector('.avatar-preview img');
                        if (preview) {
                            preview.src = event.target.result;
                        } else {
                            const container = document.querySelector('.avatar-preview');
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.style.width = '64px';
                            img.style.height = '64px';
                            img.style.borderRadius = '50%';
                            img.style.objectFit = 'cover';
                            img.style.border = '2px solid rgba(74,158,255,0.2)';
                            container.prepend(img);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
