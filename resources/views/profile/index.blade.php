@extends('layouts.app')

@section('title', 'Личный кабинет — EU Holocron')

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
        <div class="profile-member-since">
            🗓️ Хранитель с {{ $user->created_at->format('d.m.Y') }}
        </div>

        <nav class="profile-sidebar-nav">
            <a href="{{ route('profile') }}" class="active">
                <span>👤</span> Мой профиль
            </a>
            <a href="{{ route('profile.edit') }}">
                <span>✏️</span> Редактировать
            </a>
            <a href="{{ route('profile.password') }}">
                <span>🔑</span> Сменить пароль
            </a>
            <a href="/">
                <span>🏠</span> На главную
            </a>
        </nav>
    </aside>

    <main class="profile-content">
        <h2>👋 Добро пожаловать в личный кабинет!</h2>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="profile-stats">
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Сохранённых статей</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Комментариев</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Избранных</span>
            </div>
            <div class="profile-stat">
                <span class="profile-stat-number">0</span>
                <span class="profile-stat-label">Достижений</span>
            </div>
        </div>

        <div class="account-info">
            <h3>📋 Информация об аккаунте</h3>
            <div class="account-info-item">
                <span class="label">Имя</span>
                <span class="value">{{ $user->name }}</span>
            </div>
            <div class="account-info-item">
                <span class="label">Email</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <div class="account-info-item">
                <span class="label">Дата регистрации</span>
                <span class="value">{{ $user->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="account-info-item">
                <span class="label">Статус</span>
                <span class="value status">✅ Активен</span>
            </div>
        </div>
    </main>
</div>
@endsection
