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
            <a href="{{ route('timeline.index') }}" class="nav-link {{ request()->routeIs('timeline.*') ? 'active' : '' }}">Хронология</a>
            <a href="{{ route('characters.index') }}" class="nav-link {{ request()->routeIs('characters.*') ? 'active' : '' }}">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <!-- ===== ССЫЛКА НА ОБЩИЙ ЧАТ ===== -->
            <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">💬 Общий чат</a>
        </nav>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <!-- ===== РАБОЧИЙ ПОИСК ===== -->
            <div class="search-container">
                <form method="GET" action="{{ route('search') }}" style="display:flex;align-items:center;position:relative;width:100%;">
                    <input type="text" name="q" class="search-input" placeholder="Поиск по голокрону..." id="searchInput" value="{{ request()->get('q') }}">
                    <button type="submit" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:var(--text-muted);display:flex;align-items:center;transition:color 0.3s;"
                            onmouseover="this.style.color='var(--text-primary)'"
                            onmouseout="this.style.color='var(--text-muted)'">
                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- ===== БЛОК АВТОРИЗАЦИИ С РОЛЯМИ И DM ===== -->
            @auth
                <div class="user-status">
                    <!-- ===== ИКОНКА ЛИЧНЫХ СООБЩЕНИЙ ===== -->
                    <a href="{{ route('dm.index') }}"
                       style="position:relative;display:flex;align-items:center;color:var(--text-secondary);text-decoration:none;transition:color 0.3s;padding:0.25rem;border-radius:0.375rem;"
                       onmouseover="this.style.color='var(--text-primary)'"
                       onmouseout="this.style.color='var(--text-secondary)'"
                       title="Личные сообщения">
                        <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        @php
                            $unreadCount = Auth::user()->unread_messages_count ?? 0;
                        @endphp
                        @if($unreadCount > 0)
                            <span style="position:absolute;top:-2px;right:-4px;min-width:18px;height:18px;background:#FF1744;border-radius:50%;color:white;font-size:0.5rem;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 4px;box-shadow:0 0 10px rgba(255,23,68,0.4);">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
                        <img src="{{ Auth::user()->avatar_url }}" alt="Аватар"
                             style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid rgba(74,158,255,0.2);">
                        <div style="display:flex;flex-direction:column;line-height:1.2;">
                            <span class="user-name" title="{{ Auth::user()->name }}">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="role-badge {{ Auth::user()->role_class }}" style="font-size:0.5rem;padding:0.0625rem 0.375rem;margin-left:0;">
                                {{ Auth::user()->role_name }}
                            </span>
                        </div>
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
        <a href="{{ route('timeline.index') }}" class="{{ request()->routeIs('timeline.*') ? 'active' : '' }}">Хронология</a>
        <a href="{{ route('characters.index') }}" class="{{ request()->routeIs('characters.*') ? 'active' : '' }}">Персонажи</a>
        <a href="#">Библиотека</a>
        <!-- ===== ССЫЛКА НА ОБЩИЙ ЧАТ В МОБИЛЬНОМ МЕНЮ ===== -->
        <a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}">💬 Общий чат</a>
        <hr>

        <!-- ===== МОБИЛЬНОЕ МЕНЮ С РОЛЯМИ ===== -->
        @auth
            <div style="padding:0.75rem 1rem;display:flex;align-items:center;gap:0.75rem;">
                <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:inherit;width:100%;">
                    <img src="{{ Auth::user()->avatar_url }}" alt="Аватар"
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid rgba(74,158,255,0.2);">
                    <div style="display:flex;flex-direction:column;line-height:1.2;">
                        <span style="color:#EAECEE;font-size:0.875rem;font-weight:500;">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="role-badge {{ Auth::user()->role_class }}" style="font-size:0.5rem;padding:0.0625rem 0.375rem;margin-left:0;">
                            {{ Auth::user()->role_name }}
                        </span>
                    </div>
                </a>
            </div>
            <!-- ===== ССЫЛКА НА DM В МОБИЛЬНОМ МЕНЮ ===== -->
            <a href="{{ route('dm.index') }}" style="display:flex;align-items:center;gap:0.5rem;padding:0.75rem 1rem;color:var(--text-secondary);text-decoration:none;border-radius:0.5rem;transition:all 0.3s;"
               onmouseover="this.style.color='var(--text-primary)';this.style.background='rgba(255,255,255,0.05)'"
               onmouseout="this.style.color='var(--text-secondary)';this.style.background='transparent'">
                💬 Личные сообщения
                @php
                    $unreadCountMobile = Auth::user()->unread_messages_count ?? 0;
                @endphp
                @if($unreadCountMobile > 0)
                    <span style="background:#FF1744;color:white;font-size:0.6rem;font-weight:700;padding:0.0625rem 0.375rem;border-radius:9999px;">
                        {{ $unreadCountMobile > 99 ? '99+' : $unreadCountMobile }}
                    </span>
                @endif
            </a>
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
            // Фокус — анимация увеличения
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });

            // Поиск по Enter (уже работает через форму)
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
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
