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
        <div class="profile-name">
            {{ $user->name }}
            <span class="role-badge {{ $user->role_class }}">
                {{ $user->role_name }}
            </span>
        </div>
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
                <span class="label">Роль</span>
                <span class="value status" style="color: {{ match($user->role) {
                    'admin' => '#FF1744',
                    'moderator' => '#4A9EFF',
                    'guardian' => '#9B59B6',
                    default => '#39FF14',
                } }};">
                    {{ $user->role_name }}
                </span>
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

        @if($user->isAdmin())
            <div style="margin-top:1.5rem;padding:1rem;background:rgba(255,23,68,0.05);border:1px solid rgba(255,23,68,0.1);border-radius:0.75rem;">
                <h4 style="color:#FF1744;font-weight:600;font-size:0.875rem;">⚡ Верховный Хранитель</h4>
                <p style="color:var(--text-secondary);font-size:0.8125rem;margin-top:0.25rem;">
                    У вас есть полный доступ ко всем функциям сайта.
                </p>
            </div>
        @elseif($user->isModerator())
            <div style="margin-top:1.5rem;padding:1rem;background:rgba(74,158,255,0.05);border:1px solid rgba(74,158,255,0.1);border-radius:0.75rem;">
                <h4 style="color:#4A9EFF;font-weight:600;font-size:0.875rem;">⚔️ Рыцарь Хронологии</h4>
                <p style="color:var(--text-secondary);font-size:0.8125rem;margin-top:0.25rem;">
                    Вы следите за порядком в хронологии и помогаете сообществу.
                </p>
            </div>
        @endif
    </main>
</div>
@endsection
