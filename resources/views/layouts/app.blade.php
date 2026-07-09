<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EU Holocron — Legends Timeline')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<!-- ===== ШАПКА ===== -->
<header>
    <div class="header-container">
        <a href="/" class="logo">
            <span style="font-size:1.75rem;">⚡</span>
            EU Holocron
        </a>

        <nav class="nav-links">
            <a href="/" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <!-- ===== ИСПРАВЛЕННАЯ ССЫЛКА НА ХРОНОЛОГИЮ ===== -->
            <a href="{{ route('chronology.index') }}" class="nav-link {{ request()->routeIs('chronology.*') ? 'active' : '' }}">Хронология</a>
            <a href="{{ route('characters.index') }}" class="nav-link {{ request()->routeIs('characters.*') ? 'active' : '' }}">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">О проекте</a>
        </nav>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Поиск по голокрону..." id="searchInput">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            @auth
                <div class="user-status">
                    <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
                        <img src="{{ Auth::user()->avatar_url }}" alt="Аватар"
                             style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid rgba(74,158,255,0.2);">
                        <span class="user-name" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </span>
                    </a>
                    <button type="button" class="logout-btn" onclick="openLogoutModal()" title="Выйти из аккаунта">
                        ✕
                    </button>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    <svg style="width:1rem;height:1rem;margin-right:0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Войти
                </a>
            @endauth

            <button class="burger-btn" onclick="toggleMenu()" aria-label="Меню">
                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <a href="/" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
        <!-- ===== ИСПРАВЛЕННАЯ ССЫЛКА НА ХРОНОЛОГИЮ В МОБИЛЬНОМ МЕНЮ ===== -->
        <a href="{{ route('chronology.index') }}" class="{{ request()->routeIs('chronology.*') ? 'active' : '' }}">Хронология</a>
        <a href="{{ route('characters.index') }}" class="{{ request()->routeIs('characters.*') ? 'active' : '' }}">Персонажи</a>
        <a href="#">Библиотека</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">О проекте</a>
        <hr>

        @auth
            <div style="padding:0.75rem 1rem;display:flex;align-items:center;gap:0.75rem;">
                <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:inherit;width:100%;">
                    <img src="{{ Auth::user()->avatar_url }}" alt="Аватар"
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid rgba(74,158,255,0.2);">
                    <span style="color:#EAECEE;font-size:0.875rem;font-weight:500;">
                        {{ Auth::user()->name }}
                    </span>
                </a>
            </div>
            <button type="button" onclick="openLogoutModal()"
                    style="width:100%;text-align:left;padding:0.75rem 1rem;color:#E04A5F;background:none;border:none;cursor:pointer;font-size:0.875rem;border-radius:0.5rem;transition:all 0.3s;"
                    onmouseover="this.style.background='rgba(224,74,95,0.08)'"
                    onmouseout="this.style.background='transparent'">
                🚪 Выйти
            </button>
        @else
            <a href="{{ route('login') }}" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.15);color:#EAECEE;display:block;padding:0.75rem;border-radius:0.5rem;transition:all 0.3s;"
               onmouseover="this.style.background='rgba(74,158,255,0.25)'"
               onmouseout="this.style.background='rgba(74,158,255,0.15)'">
                🔑 Войти
            </a>
        @endauth
    </div>
</header>

<!-- ===== ОСНОВНОЙ КОНТЕНТ ===== -->
<main>
    @yield('content')
</main>

<!-- ===== ФУТЕР ===== -->
<footer>
    <div class="footer-container">
        <p class="footer-text">
            © {{ date('Y') }} EU Holocron.
            <span style="color:#49525E;">⚡</span>
            Расширенная вселенная.
        </p>
        <div class="footer-links">
            <a href="{{ route('about') }}">О проекте</a>
            <a href="#"><span>🐙</span> GitHub</a>
            <a href="#"><span>✉️</span> Обратная связь</a>
        </div>
    </div>
</footer>

<!-- ===== COOKIES-УВЕДОМЛЕНИЕ ===== -->
<div class="cookie-banner" id="cookieBanner" role="alert" aria-live="polite">
    <span class="cookie-icon">🍪</span>
    <div class="cookie-text">
        <strong>Мы используем cookies</strong> для улучшения работы сайта.
        Продолжая использовать наш сайт, вы соглашаетесь с нашей
        <a href="#" onclick="event.preventDefault();">Политикой конфиденциальности</a>.
    </div>
    <button class="cookie-btn" onclick="acceptCookies()">Принять</button>
</div>

<!-- ===== МОДАЛЬНОЕ ОКНО ПОДТВЕРЖДЕНИЯ ВЫХОДА ===== -->
<div class="logout-modal-overlay" id="logoutModal">
    <div class="logout-modal">
        <div class="logout-modal-header">
            <span class="logout-modal-icon">🚪</span>
            <h2>Подтверждение выхода</h2>
            <button class="logout-modal-close" onclick="closeLogoutModal()">✕</button>
        </div>
        <div class="logout-modal-body">
            <p>Вы уверены, что хотите выйти из своего аккаунта?</p>
            <p class="logout-modal-hint">Все несохранённые изменения будут потеряны.</p>
        </div>
        <div class="logout-modal-footer">
            <button class="btn-cancel" onclick="closeLogoutModal()">Отмена</button>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="submit" class="btn-logout-confirm">Выйти</button>
            </form>
        </div>
    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script>
    // ===== МОБИЛЬНОЕ МЕНЮ =====
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const btn = document.querySelector('.burger-btn');
        if (menu.classList.contains('open') && !menu.contains(event.target) && !btn.contains(event.target)) {
            menu.classList.remove('open');
        }
    });

    // ===== ПОИСК =====
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        }
    });

    // ===== COOKIES =====
    function acceptCookies() {
        document.getElementById('cookieBanner').classList.remove('show');
        localStorage.setItem('cookiesAccepted', 'true');
    }

    function checkCookies() {
        const isAuth = @auth true @else false @endauth;
        const cookiesAccepted = localStorage.getItem('cookiesAccepted') === 'true';

        if (isAuth && !cookiesAccepted) {
            setTimeout(() => {
                document.getElementById('cookieBanner').classList.add('show');
            }, 1000);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkCookies();
        const banner = document.getElementById('cookieBanner');
        banner.addEventListener('click', function(e) {
            if (e.target.classList.contains('cookie-btn')) {
                this.classList.remove('show');
            }
        });
    });

    // ===== МОДАЛЬНОЕ ОКНО ВЫХОДА =====
    function openLogoutModal() {
        document.getElementById('logoutModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('logoutModal');
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeLogoutModal();
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>
