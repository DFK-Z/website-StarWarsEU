@extends('layouts.app')

@section('title', 'Star Wars EU Holocron — Legends Timeline')

@section('content')
<!-- ===== ГЕРОЙ ===== -->
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            @auth
                Добро пожаловать, Хранитель {{ Auth::user()->name }}!
                <span class="role-badge {{ Auth::user()->role_class }}" style="font-size:0.5rem;padding:0.0625rem 0.375rem;">
                    {{ Auth::user()->role_name }}
                </span>
            @else
                Legends Timeline — Expanded Universe
            @endauth
        </div>

        <h1 class="hero-title">
            <span>Хранители Голокрона</span>
        </h1>

        <p class="hero-subtitle">
            Исследуйте хронику расширенной вселенной «Звёздных войн».<br>
            От Трауна до Юужань-Вонгов — без Диснея и Войн Клонов 2008.
        </p>

        <div class="hero-buttons">
            <a href="#" class="btn-primary">
                Начать путешествие
                <svg style="width:1rem;height:1rem;margin-left:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('about') }}" class="btn-secondary">О проекте</a>
        </div>
    </div>
</section>

<!-- ===== КАРТОЧКИ ===== -->
<section class="cards">
    <div class="cards-grid">
        <div class="card">
            <span class="card-icon">📜</span>
            <div class="card-title">Хронология</div>
            <div class="card-text">От Старой Республики до Новой</div>
        </div>
        <a href="{{ route('characters.index') }}" class="card" style="text-decoration:none;color:inherit;display:block;">
            <span class="card-icon">👤</span>
            <div class="card-title">Персонажи</div>
            <div class="card-text">Траун, Люк, Мара и многие другие</div>
        </a>
        <div class="card">
            <span class="card-icon">🌍</span>
            <div class="card-title">Планеты</div>
            <div class="card-text">Корусант, Татуин, Бастион</div>
        </div>
    </div>
</section>
@endsection
