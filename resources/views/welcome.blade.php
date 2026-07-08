<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Star Wars EU Holocron — Legends Timeline</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
            <a href="/" class="nav-link active">Главная</a>
            <a href="#" class="nav-link">Хронология</a>
            <a href="#" class="nav-link">Персонажи</a>
            <a href="#" class="nav-link">Библиотека</a>
            <a href="#" class="nav-link">О проекте</a>
        </nav>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Поиск по голокрону..." id="searchInput">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- ===== БЛОК АВТОРИЗАЦИИ С АВАТАРКОЙ ===== -->
            @auth
                <div class="user-status">
                    <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
                        <div class="user-avatar" style="background-image:url('{{ Auth::user()->avatar_url }}');background-size:cover;background-position:center;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#0B0D10;text-transform:uppercase;flex-shrink:0;">
                            @if(!Auth::user()->getFirstMedia('avatar'))
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <span class="user-name" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn" title="Выйти из аккаунта">
                            ✕
                        </button>
                    </form>
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
        <a href="/" class="active">Главная</a>
        <a href="#">Хронология</a>
        <a href="#">Персонажи</a>
        <a href="#">Библиотека</a>
        <a href="#">О проекте</a>
        <hr>

        @auth
            <div style="padding:0.75rem 1rem;display:flex;align-items:center;gap:0.75rem;">
                <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:inherit;width:100%;">
                    <div class="user-avatar" style="width:32px;height:32px;border-radius:50%;background-image:url('{{ Auth::user()->avatar_url }}');background-size:cover;background-position:center;display:flex;align-items:center;justify-content:center;font-size:0.875rem;font-weight:700;color:#0B0D10;text-transform:uppercase;flex-shrink:0;">
                        @if(!Auth::user()->getFirstMedia('avatar'))
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <span style="color:#EAECEE;font-size:0.875rem;font-weight:500;">
                        {{ Auth::user()->name }}
                    </span>
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%;text-align:left;padding:0.75rem 1rem;color:#E04A5F;background:none;border:none;cursor:pointer;font-size:0.875rem;border-radius:0.5rem;transition:all 0.3s;"
                        onmouseover="this.style.background='rgba(224,74,95,0.08)'"
                        onmouseout="this.style.background='transparent'">
                    🚪 Выйти
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="margin-top:0.5rem;text-align:center;background:rgba(74,158,255,0.15);color:#EAECEE;display:block;padding:0.75rem;border-radius:0.5rem;transition:all 0.3s;"
               onmouseover="this.style.background='rgba(74,158,255,0.25)'"
               onmouseout="this.style.background='rgba(74,158,255,0.15)'">
                🔑 Войти
            </a>
        @endauth
    </div>
</header>

<!-- ===== ГЕРОЙ ===== -->
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            @auth
                Добро пожаловать, Хранитель {{ Auth::user()->name }}! 👋
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
            <a href="#" class="btn-secondary">О проекте</a>
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
        <div class="card">
            <span class="card-icon">👤</span>
            <div class="card-title">Персонажи</div>
            <div class="card-text">Траун, Люк, Мара и многие другие</div>
        </div>
        <div class="card">
            <span class="card-icon">🌍</span>
            <div class="card-title">Планеты</div>
            <div class="card-text">Корусант, Татуин, Бастион</div>
        </div>
    </div>
</section>

<!-- ===== ФУТЕР ===== -->
<footer>
    <div class="footer-container">
        <p class="footer-text">
            © {{ date('Y') }} EU Holocron.
            <span style="color:#49525E;">⚡</span>
            Расширенная вселенная.
        </p>
        <div class="footer-links">
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

<!-- ===== SCRIPTS ===== -->
<script>
    // ===== МОБИЛЬНОЕ МЕНЮ =====
    function toggleMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const btn = document.querySelector('.burger-btn');
        if (menu.classList.contains('open') &&
            !menu.contains(event.target) &&
            !btn.contains(event.target)) {
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
</script>

</body>
</html>
